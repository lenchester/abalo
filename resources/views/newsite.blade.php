<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>articles</title>
    <script src="js/vue.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<script src=”https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js” integrity=”sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo” crossorigin=”anonymous”></script>
<script src=”https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js” integrity=”sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/” crossorigin=”anonymous”></script>

<div id='app'>
    <site-header></site-header>
    @verbatim
    <site-body :show-impressum="showImpressum"></site-body>

    <site-footer @show="show"></site-footer>
    @endverbatim
</div>
<div id="cookieNotice" class="light display-right" style="display: none;">
    <div id="closeIcon" style="display: none;">
    </div>
    <div class="title-wrap">
        <h4>Cookie Consent</h4>
    </div>
    <div class="content-wrap">
        <div class="msg-wrap">
            <p>TSeit Mai 2018 gilt die EU DSGVO (EU-Datenschutz- grundverordnung). Die DSGVO verlangt, dass bei Verwendung von Cookies der/die Nutzer:in über die Verwendung selbst sowie über die geltende Rechtsgrundlage unterrichtet wird. Ein Beispiel finden Sie unter https://www.fh- aachen.de.  <a style="color:#115cfa;" href="/privacy-policy">Privacy Policy</a></p>
            <div class="btn-wrap">
                <button class="btn-primary" onclick="acceptCookieConsent();">Accept</button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import SiteHeader from './js/siteheader.js';
    import SiteBody from './js/sitebody.js';
    import SiteFooter from './js/sitefooter.js';
    var vm = Vue.createApp({
        data() {
            return {
                showImpressum: false
            };
        },
        components: {
                SiteHeader,
                SiteBody,
                SiteFooter
        },
        methods: {
            show(){
                this.showImpressum = !this.showImpressum;
            }
        }


    }).mount('#app');

</script>

</body>
</html>


<script>
</script>
