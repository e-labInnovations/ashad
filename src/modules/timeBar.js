class TimeBar {
    constructor() {
        this.post = document.querySelector('.post-content');
        this.timeBar = document.querySelector('.time-bar');
        this.shouldShow = true;

        if (this.post && this.timeBar) {
            this.lastScrollTop = 0;
            this.maxScrollTop = this.post.scrollHeight;

            this.completed = this.timeBar.querySelector('.completed');
            this.remaining = this.timeBar.querySelector('.remaining');
            this.timeCompleted = this.timeBar.querySelector('.time-completed');
            this.timeRemaining = this.timeBar.querySelector('.time-remaining');

            document.addEventListener('scroll', this.scrollFunction.bind(this));
        }
    }

    scrollFunction() {
        this.scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (this.scrollTop > this.lastScrollTop && this.shouldShow) {
            this.timeBar.style.bottom = '0%';
        } else {
            this.timeBar.style.bottom = '-100%';
        }

        if (this.scrollTop <= this.maxScrollTop) {
            var percentage = this.scrollTop / this.maxScrollTop;

            var completedVal = (percentage * 100).toFixed(2);
            var remainingVal = 100 - parseFloat(completedVal);
            this.completed.style.width = completedVal.toString() + '%';
            this.remaining.style.width = remainingVal.toString() + '%';

            var totalSeconds = parseInt(this.timeBar.getAttribute('data-minutes')) * 60;

            var completedTime = parseInt(percentage * totalSeconds);
            var completedMin = parseInt(completedTime / 60);
            var completedSec = parseInt((completedTime / 60 - completedMin) * 60);

            var remainingTime = totalSeconds - completedTime;
            var remainingMin = parseInt(remainingTime / 60);
            var remainingSec = parseInt((remainingTime / 60 - remainingMin) * 60);

            completedMin = (completedMin < 10) ? '0' + completedMin : completedMin;
            completedSec = (completedSec < 10) ? '0' + completedSec : completedSec;
            remainingMin = (remainingMin < 10) ? '0' + remainingMin : remainingMin;
            remainingSec = (remainingSec < 10) ? '0' + remainingSec : remainingSec;

            this.timeCompleted.innerText = completedMin + ':' + completedSec;
            this.timeRemaining.innerText = remainingMin + ':' + remainingSec;

            this.shouldShow = true;

            this.triggerStillReading();
        } else {
            this.completed.style.width = '100%';
            this.remaining.style.width = '0%';

            var minutes = parseInt(this.timeBar.getAttribute('data-minutes'));
            minutes = (minutes < 10) ? '0' + minutes : minutes;

            this.timeCompleted.innerText = '00:00';
            this.timeRemaining.innerText = minutes + ':00';

            this.shouldShow = false;

            this.triggerFinishedReading();
        }

        this.lastScrollTop = this.scrollTop;
    }

    triggerStillReading() {
        var readEvent = new Event('stillReading');
        document.dispatchEvent(readEvent);
    }

    triggerFinishedReading() {
        var readEvent = new Event("finishedReading");
        document.dispatchEvent(readEvent);
    }
}

export default TimeBar