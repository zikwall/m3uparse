package _go

type Playlist struct {
	EpgId int
	Name  string
	Url   string
	From  string
}

type Normal struct {
	Origin  string
	Various []string
	Use     bool
}
