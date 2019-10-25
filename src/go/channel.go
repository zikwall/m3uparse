package _go

import (
	"encoding/json"
	"fmt"
	"io/ioutil"
	"path/filepath"
)

func ChannelMerge(channels ...map[string]int) map[int]*Normal {
	normals := GetListAvailableChannels()

	for _, channel := range channels {
		for name, id := range channel {

			// if not exist this channel (id) in normalize channels
			if _, ok := normals[id]; !ok {
				continue
			}

			// add possible name
			normals[id].Various = append(normals[id].Various, name)
		}
	}

	// sanitize
	for k, v := range normals {
		// off
		if v.Use == false {
			delete(normals, k)
		}

		// not availabe channels (names)
		if len(v.Various) <= 0 {
			delete(normals, k)
		}
	}

	return normals
}

func GetListAvailableChannels() map[int]*Normal {
	normals := map[int]*Normal{}
	absPath, _ := filepath.Abs("./channels/normilize.json")
	plan, err := ioutil.ReadFile(absPath)

	if err != nil {
		panic(err)
	}

	if err := json.Unmarshal(plan, &normals); err != nil {
		panic(err)
	}

	return normals
}

func GetWhiteListChannels(name string) map[string]int {
	result := map[string]int{}

	absPath, _ := filepath.Abs(fmt.Sprintf("./channels/%s.json", name))
	plan, err := ioutil.ReadFile(absPath)

	if err != nil {
		panic(err)
	}

	if err := json.Unmarshal(plan, &result); err != nil {
		panic(err)
	}

	return result
}
