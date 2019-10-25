package parsers

import (
	parse "../../go"
	"io/ioutil"
	"strings"
)

func FreeBEstTv() []parse.Playlist {
	if err := parse.DownloadFile("./plists/uploads/free_best_tv.m3u", parse.URLS["free_best_tv"]); err != nil {
		panic(err)
	}

	b, err := ioutil.ReadFile("./plists/uploads/free_best_tv.m3u")

	if err != nil {
		panic(err)
	}

	s := strings.Split(string(b), "#EXTINF:-1,")
	result := []parse.Playlist{}

	for _, pl := range s[3:] {
		item := strings.Split(pl, "\n")
		name := strings.TrimSpace(item[0])
		url := strings.TrimSpace(item[1])

		if !strings.Contains(url, "http") {
			continue
		}

		result = append(result, parse.Playlist{
			Name: name,
			Url:  url,
			From: "free_best_tv",
		})
	}

	return result
}
