import $ from 'jquery';
import ouibounce from './ouibounce';
import './scrollanimation'
import smoothScroll from './smoothscroll';

import { gsap } from "gsap";

class zmain {
    constructor() {
        this.previousValue
        this.typingTimer
        this.isSpinnerVisible = false

        // Menu
        document.getElementById("menu").addEventListener("click", () => {
            document.querySelector("body").classList.add("push-menu-to-right")
            document.querySelector("#sidebar").classList.add("open")
            document.querySelector(".overlay").classList.add("show")
        })

        document.getElementById("mask").addEventListener("click", () => {
            document.querySelector("body").classList.remove("push-menu-to-right")
            document.querySelector("#sidebar").classList.remove("open")
            document.querySelector(".overlay").classList.remove("show")
        })

        //Header
        window.addEventListener("scroll", () => {
            var supportPageOffset = window.pageXOffset !== undefined;
            var isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");
            var top = supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
            if (top > 0) {
                document.querySelector("body").classList.add("light")
            } else {
                document.querySelector("body").classList.remove("light")
            }
        })

        // Modals
        var closeBtn = document.querySelector('.modal .close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                closeBtn.parentNode.parentNode.classList.add('closed');
            });
        }

        var exitModal = document.querySelectorAll('.modal.exit');
        if (exitModal.length) {
            ouibounce(exitModal[0], {
                aggressive: true,
                callback: function() {
                    exitModal[0].querySelector('.close').addEventListener('click', function() {
                        exitModal[0].style.display = "none";
                    });
                }
            });
        }

        // Search
        this.bs = {
            close: document.querySelector(".icon-remove-sign"),
            searchform: document.querySelector(".search-form"),
            canvas: document.querySelector("body"),
            searchFiled: document.querySelector('.search-field'),
            dothis: document.querySelector('.dosearch')
        };
        this.bs.dothis.addEventListener('click', () => {
            document.querySelector('.search-wrapper').classList.toggle('active');
            this.bs.searchform.classList.toggle('active');
            this.bs.searchFiled.focus();
            this.bs.canvas.classList.toggle('search-overlay');
            this.bs.searchFiled.addEventListener('keyup', this.typingLogic.bind(this));
        });

        this.bs.close.addEventListener('click', this.close_search.bind(this));

        // Closing menu with ESC
        document.addEventListener('keyup', this.keyboardCloseSearch.bind(this));


        // if (document.getElementsByClassName('home').length >= 1) {
        //     new AnimOnScroll(document.getElementById('grid'), {
        //         minDuration: 0.4,
        //         maxDuration: 0.7,
        //         viewportFactor: 0.2
        //     });
        // }

        // Init smooth scroll
        smoothScroll.init({
            selectorHeader: '.bar-header', // Selector for fixed headers (must be a valid CSS selector)
            speed: 500, // Integer. How fast to complete the scroll in milliseconds
            updateURL: false // Boolean. Whether or not to update the URL with the anchor hash on scroll
        });

        var t1 = gsap.timeline({defaults: {duration: 1}})

        t1.from('.hero', { opacity: 0, y:-50 })
            .from('.box-item', { opacity: 0, y:-50, ease: 'Power2.easeOut', stagger: 0.3 }, '-=0.3')
        
        // gsap.from('.hero', { opacity: 0, duration: 1, y:-50 })
        // gsap.from('.box-item', { opacity: 0, duration: 1, y:-50, delay: 1, ease: 'Power2.easeOut', stagger: 0.3 })

    }

    close_search() {
        document.querySelector('.search-wrapper').classList.toggle('active')
        this.bs.searchform.classList.toggle('active')
        this.bs.canvas.classList.remove('search-overlay');
    }

    keyboardCloseSearch(e) {
        if (e.keyCode == 27 && $('.search-overlay').length) {
            this.close_search();
        }
    }

    // fetch() {
    //     $.ajax({
    //         url: ashad.fetchURL,
    //         type: 'post',
    //         data: { action: 'data_fetch', keyword: $('#keyword').val() },
    //         success: function(data) {
    //             $('#datafetch').html(data);
    //         }
    //     });
    // }

    typingLogic() {
        let s = this.bs.searchFiled.value
        if (s != this.previousValue) {
            clearTimeout(this.typingTimer)

            if (s) {
                if (!this.isSpinnerVisible) {
                    document.querySelector('.search-results').innerHTML = '<div class="spinner-loader"></div>'
                    this.isSpinnerVisible = true
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750)
            } else {
                document.querySelector('.search-results').innerHTML = ""
                this.isSpinnerVisible = false
            }
        }

        this.previousValue = s
    }

    getResults() {
        let s = this.bs.searchFiled.value

        $.ajax({
            url: ashad.root_url + '/wp-json/ashad/v1/search?s=' + s,
            type: 'get',
            data: { action: 'data_fetch', keyword: $('#keyword').val() },
            success: data => {
                let postsHTML = '<h2 style="color: #fff;">Blog</h2>' + data.posts.map(post => `
                <li>
                    <article>
                        <a href="${post.url}">
                            <span class="entry-category">${post.categories[0]}</span>
                            ${post.title}
                            <span class="entry-date"><time datetime="${post.date}">${post.date}</time></span>
                        </a>
                    </article>
                </li>
                `).join('')
                let codeSnippetsHTML = '<h2 style="color: #fff;">Code Snippets</h2>' + data.code_snippets.map(post => `
                <li>
                    <article>
                        <a href="${post.url}">
                            <span class="entry-category">${post.languages[0].name}</span>
                            ${post.title}
                            <span class="entry-date"><time datetime="${post.date}">${post.date}</time></span>
                        </a>
                    </article>
                </li>
                `).join('')

                document.querySelector('.search-results').innerHTML = postsHTML + codeSnippetsHTML
            }
        });
    }
}

export default zmain