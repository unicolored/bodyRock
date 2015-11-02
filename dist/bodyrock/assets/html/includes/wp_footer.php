<!-- Schema.org -->
<script type="application/ld+json">{ "@context": "https://schema.org", "@type": "WebSite", "url": "http://www.gilleshoarau.com/", "potentialAction": { "@type": "SearchAction", "target": "http://www.gilleshoarau.com/?s={search_term}", "query-input": "required name=search_term" } }</script>

<!-- Google Analytics -->
<script type="text/javascript">(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date(); a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1; a.src=g;m.parentNode.insertBefore(a,m)}) (window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-67465-34', 'auto'); ga('send', 'pageview');</script>
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script type='text/javascript' src='http://www.gilleshoarau.com/da/wp-content/themes/rock-gilleshoarau/dev/_tmp/bower_concat.js'></script>
<script type='text/javascript' src='http://www.gilleshoarau.com/da/wp-content/themes/rock-gilleshoarau/dev/javascript/script.js'></script>
<script type="text/javascript">(function() {
  function addSubmittedClassToFormContainer(e) {
    var form = e.target.form.parentNode;
    var className = 'mc4wp-form-submitted';
    (form.classList) ? form.classList.add(className) : form.className += ' ' + className;
  }

  function maybePrefixUrlField() {
    if(this.value.trim() !== '' && this.value.indexOf('http') !== 0) {
      this.value = "http://" + this.value;
    }
  }

  var forms = document.querySelectorAll('.mc4wp-form');
  for (var i = 0; i < forms.length; i++) {
    (function(f) {

      /* add class on submit */
      var b = f.querySelector('[type="submit"], [type="image"]');
      if( b ) {
        if(b.addEventListener) {
          b.addEventListener('click', addSubmittedClassToFormContainer);
        } else {
          b.attachEvent('click', addSubmittedClassToFormContainer);
        }
      }

      /* better URL fields */
      var urlFields = f.querySelectorAll('input[type="url"]');
      if( urlFields && urlFields.length > 0 ) {
        for( var j=0; j < urlFields.length; j++ ) {
          if(urlFields[j].addEventListener) {
            urlFields[j].addEventListener('blur', maybePrefixUrlField);
          } else {
            urlFields[j].attachEvent( 'blur', maybePrefixUrlField);
          }
        }
      }

    })(forms[i]);
  }
})();

</script>
