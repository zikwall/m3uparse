package _go

import (
	"./helpers"
)

func PlaylistMerge(channels map[int]*Normal, playlists ...[]Playlist) map[int]*Playlist {
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
					Name:  v.Origin,
					Url:   item.Url,
					EpgId: id,
					From:  item.From,
				}
			}
		}
	}

	return result
}
