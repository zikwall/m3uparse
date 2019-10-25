package main

import (
	"./src/go"
	"./src/go/channels"
	"./src/go/parsers"
	//"encoding/json"
	"fmt"
)

func main() {
	free := parsers.Free()

	aggregated := _go.PlaylistMerge(_go.ChannelMerge(channels.Free()), free)

	for _, i := range aggregated {
		fmt.Printf("Name: %s Url: %s\n", i.Name, i.Url)
	}

	/*b, err := json.Marshal(_go.ChannelMerge(channels.Free()))

	if err != nil {
		panic(err)
	}

	fmt.Println(string(b))*/
}
