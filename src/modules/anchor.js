class Ancher {
    constructor() {
        var headings = document.querySelectorAll('.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6');
        for (var i = 0; i < headings.length; i++) {
            if (headings[i].getAttribute('id')) {
                var img = document.createElement('img');
                img.setAttribute('src', ashad.assets_url + '/img/link-symbol.svg');

                var a = document.createElement('a');
                a.setAttribute('href', '#' + headings[i].getAttribute('id'));
                a.classList.add('anchor');
                a.appendChild(img);

                headings[i].insertBefore(a, headings[i].firstChild);
            }
        }
    }
}

export default Ancher