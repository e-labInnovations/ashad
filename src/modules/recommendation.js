class recommendation {
    constructor() {
        this.recommendation = document.querySelector('.recommendation');
        this.isVisible = false;
        this.timeOut;

        this.events();
    }

    events() {
        if (this.recommendation) {
            // Back to top button
            var goBackToTop = this.recommendation.querySelector('.message button');
            goBackToTop.addEventListener('click', this.backToTop.bind(this));

            // Hide
            document.addEventListener('stillReading', this.hide.bind(this), false);

            // Show
            document.addEventListener('finishedReading', this.show.bind(this), false);
        }
    }

    backToTop() {
        this.scrollToTop();
        return false;
    }

    hide(elem) {
        if (this.isVisible) {
            this.recommendation.style.bottom = '-100%';
            this.isVisible = false;
        }
    }

    show(elem) {
        if (!this.isVisible) {
            this.recommendation.style.bottom = '0%';
            this.isVisible = true;
        }
    }

    scrollToTop() {
        console.log(this);
        if (document.body.scrollTop != 0 || document.documentElement.scrollTop != 0) {
            window.scrollBy(0, -50);
            this.timeOut = setTimeout(this.scrollToTop.bind(this), 10);
        } else clearTimeout(this.timeOut);
    }
}

export default recommendation