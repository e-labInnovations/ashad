<?php get_header(); ?>

<style type="text/css" media="screen">
  .container {
    margin: 0px auto;
    max-width: 600px;
  }
</style>

<section class="content">
    <div class="post">
        <article class="post-content fullwidth">

            <div class="container">
                <h2>Talk to me</h2>
                <div id="form" class="contact-form">
                    <form accept-charset="UTF-8" method="POST" action="#" v-on:submit.prevent="validateBeforeSubmit" ref="contact">
                    <fieldset>
                        <input type="hidden" name="_subject" value="New contact!" />

                        <input type="text" name="name" placeholder="Your name" v-validate="'required'"
                            :class="{ 'has-error': errors.has('name') }">
                        <span v-if="errors.has('name')" v-cloak>${ errors.first('name') }</span>

                        <input type="text" name="email" placeholder="Your email" v-validate="'required|email'"
                            :class="{ 'has-error': errors.has('email') }">
                        <span v-if="errors.has('email')" v-cloak>${ errors.first('email') }</span>

                        <input type="text" name="subject" placeholder="Subject" v-validate="'required'"
                            :class="{ 'has-error': errors.has('subject') }">
                        <span v-if="errors.has('subject')" v-cloak>${ errors.first('subject') }</span>

                        <textarea name="message" onkeyup="adjust_textarea(this)" placeholder="Your message" v-validate="'required'"
                                :class="{ 'has-error': errors.has('message') }"></textarea>
                        <span v-if="errors.has('message')" v-cloak>${ errors.first('message') }</span>

                        <button type="submit">Send</button>
                    </fieldset>
                    </form>
                </div>
            </div>
        </article>

    </div>
</section>

<script type="text/javascript">
function adjust_textarea(h) {
    h.style.height = "200px";
    h.style.height = (h.scrollHeight)+"px";
}
</script>

<script src="https://unpkg.com/vue@2.4.2"></script>
<script src="https://unpkg.com/vee-validate@2.0.0-rc.8"></script>
<script type="text/javascript">
Vue.use(VeeValidate);

const dictionary = {
    custom: {
      name: {
        required: "Name is required"
      },
      email: {
        required: "Email is required",
        email: "Email is invalid"
      },
      subject: {
        required: "Message subject is required"
      },
      message: {
        required: "Message is required"
      }
    }
};

VeeValidate.Validator.updateDictionary(dictionary);
VeeValidate.Validator.setLocale("en");

new Vue({
  el: '#form',
  delimiters: ['${', '}'],
  methods: {
    validateBeforeSubmit: function () {
      this.$validator.validateAll();
      if (!this.errors.any()) {
        this.$refs.contact.submit();
      }
    }
  }
});
</script>

<?php get_footer(); ?>