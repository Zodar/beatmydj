SC.initialize({
	client_id: 'ddba0ef4e2487fee58c38aa556b167bd'
});

var track_url = $("input[name='user_playlist_link']").val();
var element_node = document.getElementById('user_playlist');
SC.oEmbed(track_url, { element: element_node, maxheight: '300px', show_comments: false }).then(function(oEmbed) {});