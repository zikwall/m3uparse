package main

import (
	"./src/consts"
	parse "./src/go"
	"fmt"
	"io/ioutil"
	"strings"
)

type Playlist struct {
	Name string
	Url  string
}

func main() {
	if err := parse.DownloadFile("./plists/uploads/free.m3u", consts.FREE_URL); err != nil {
		panic(err)
	}

	b, err := ioutil.ReadFile("./plists/uploads/free.m3u")

	if err != nil {
		panic(err)
	}

	str := string(b)
	s := strings.Split(str, "#EXTINF:-1,")

	for _, pl := range s[3:] {
		item := strings.Split(pl, "\n")
		name := strings.TrimSpace(item[0])
		url := strings.TrimSpace(item[1])

		if !strings.Contains(url, "http") {
			continue
		}

		fmt.Printf("Name: %s Url: %s \n", name, url)
	}
}
