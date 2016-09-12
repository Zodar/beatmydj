SC.initialize({
	client_id: 'ddba0ef4e2487fee58c38aa556b167bd'
});

var track_url = 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj';
var element_node = document.getElementById('play_sound');
SC.oEmbed(track_url, { element: element_node, auto_play: true }).then(function(oEmbed) {
	
});