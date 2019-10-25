package channels

import (
	"../../go"
)

func Free() map[string]int {
	return _go.GetWhiteListChannels("free")
}
