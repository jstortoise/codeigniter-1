<!-- This is Google Ad Code, please do not make changes on following code -->

<div class="container">
    <div id="google-ads-1"></div>

    <script type="text/javascript">

        /* Calculate the width of available ad space */
        ad = document.getElementById('google-ads-1');

        if (ad.getBoundingClientRect().width) {
            adWidth = ad.getBoundingClientRect().width; // for modern browsers
        } else {
            adWidth = ad.offsetWidth; // for old IE
        }

        /* Replace ca-pub-XXX with your AdSense Publisher ID */
        google_ad_client = "ca-pub-8451164086915508";

        /* Replace 1234567890 with the AdSense Ad Slot ID */
        google_ad_slot = "7376237473";

        /* Do not change anything after this line */
        if (adWidth >= 980)
            google_ad_size = ["970", "90"];  /* Leaderboard 728x90 */
        else if (adWidth >= 468)
            google_ad_size = ["468", "90"];  /* Banner (468 x 60) */
        else if (adWidth >= 336)
            google_ad_size = ["336", "90"]; /* Large Rectangle (336 x 280) */
        else if (adWidth >= 300)
            google_ad_size = ["300", "90"]; /* Medium Rectangle (300 x 250) */
        else if (adWidth >= 250)
            google_ad_size = ["250", "90"]; /* Square (250 x 250) */
        else if (adWidth >= 200)
            google_ad_size = ["200", "90"]; /* Small Square (200 x 200) */
        else if (adWidth >= 180)
            google_ad_size = ["180", "90"]; /* Small Rectangle (180 x 150) */
        else
            google_ad_size = ["125", "90"];
        /* Button (125 x 125) */

        document.write(
            '<ins class="adsbygoogle" style="display:inline-block;width:'
            + google_ad_size[0] + 'px;height:'
            + google_ad_size[1] + 'px" data-ad-client="'
            + google_ad_client + '" data-ad-slot="'
            + google_ad_slot + '"></ins>'
        );

        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</div>
<!-- Google Code End here -->