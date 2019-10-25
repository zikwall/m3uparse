package _go

import (
	ch "./channels"
	"./helpers"
)

func PlaylistMerge(channels map[int]*ch.Normal, playlists ...[]Playlist) map[int]*Playlist {
	result := map[int]*Playlist{}

	// all playlists
	for _, pl := range playlists {
		// into playlist
		for _, item := range pl {
			// loop all available channels
			for id, v := range channels {
				// if channel already exist
				if _, ok := result[id]; ok {
					continue
				}

				// if available channel names not includes this channel name
				if !helpers.ContainsString(v.Various, item.Name) {
					continue
				}

				result[id] = &Playlist{
					Name: v.Origin,
					Url:  item.Url,
				}
			}
		}
	}

	return result
}

func ChannelMerge(channels ...map[string]int) map[int]*ch.Normal {
	normals := ch.Normales

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
		if len(v.Various) <= 0 {
			delete(normals, k)
		}
	}

	return normals
}
