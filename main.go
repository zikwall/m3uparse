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
	freeBestTv := parsers.FreeBEstTv()

	aggregated := _go.PlaylistMerge(_go.ChannelMerge(channels.Free()), free, freeBestTv)

	for _, i := range aggregated {
		fmt.Printf("%s | # %d Name: %s Url: %s\n", i.From, i.EpgId, i.Name, i.Url)
	}
}
