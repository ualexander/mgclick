<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="../js/moment-min.js"></script>
<script src="../js/daterangepicker-min.js"></script>

<?php if(!isset($data['printCalc']) || (isset($data['printCalc']) && $data['printCalc'] === true)): ?>
  <script src="../js/print-calc-min.js"></script>
<?php endif; ?>

<?php if(isset($data['yaMetrika']) && (isset($data['yaMetrika']) && $data['yaMetrika'] === true)): ?>
  <!-- Yandex.Metrika counter -->
  <script type="text/javascript" >
    (function (d, w, c) {
      (w[c] = w[c] || []).push(function() {
        try {
          w.yaCounter48409331 = new Ya.Metrika({
            id:48409331,
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
          });
        } catch(e) { }
      });

      var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
      s.type = "text/javascript";
      s.async = true;
      s.src = "https://mc.yandex.ru/metrika/watch.js";

      if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
      } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
  </script>
  <noscript><div><img src="https://mc.yandex.ru/watch/48409331" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
  <!-- /Yandex.Metrika counter -->
<?php endif; ?>

<script src="../js/rocket-main.js"></script>