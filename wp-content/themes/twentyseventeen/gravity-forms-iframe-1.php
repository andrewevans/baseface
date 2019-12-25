<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="robots" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="ItnPsPAJ43QzJtkVPf8WwViXoeD22AeDLOqAkQMO">
    <link rel="icon" href="https://www.masterworksfineart.com/favicon-mfa.ico">

    <title><?php echo esc_html( $form['title'] ); ?></title>
    <style type="text/css">
        body {
            padding: 0;
            font-family: sans-serif;
            font-size: 13px;
        }
    </style>
    <?php do_action( 'gfiframe_head', $form_id, $form ); ?>

    <script>
      window.Laravel = {"csrfToken":"ItnPsPAJ43QzJtkVPf8WwViXoeD22AeDLOqAkQMO"};
    </script>
</head>

<body class="theme-default">
<style>
    .v4-tease, .v4-tease:hover, .v4-tease:visited {
        display: block;
        padding: 15px 20px;
        font-weight: 700;
        color: #fff;
        text-align: center;
        background-color: #6383a1;
    }
</style>


<div class="navbar navbar-default" role="navigation">
    <div class="container size-xs">
        <div class="contact-us-info">
            <span class="phone-number">510-777-9970</span> / <span id="phone_number_800">800-805-7060</span>
            <span class="address size-s"> / 13470 Campus Drive, Oakland Hills, CA 94619 USA</span>
        </div>

        <div class="collapse navbar-collapse" style="float: right;">
            <ul class="nav navbar-nav navbar-secondary" style="border-top: 2px solid #004b91; margin-left: 0">
                <li><a href="https://news.masterworksfineart.com">Art News</a></li>
                <li><a href="https://www.masterworksfineart.com/contact-gallery/how-to-sell-fine-art-you-own"><i>Sell Your Fine Art</i></a></li>
                <!--<li><a href="/login"><span class="size-l">Sign in</span> <span class="glyphicon glyphicon-log-in"></span></a></li>-->
                <li><a href="https://shop.masterworksfineart.com/cart"><span class="size-l">Shopping Bag</span> <span class="glyphicon glyphicon-shopping-cart"></span> <span class="badge shop-cart-count"></span></a></li>
            </ul>

        </div>
    </div>
    <div class="container">

        <div class="logo hidden-xs">
            <a href="https://www.masterworksfineart.com"><img src="https://images.masterworksfineart.com/masterworks-fine-art-gallery.gif" alt="Masterworks Fine Art Gallery"></a>
        </div>
        <div class="logo-xs visible-xs-block"><a href="https://www.masterworksfineart.com"><img src="https://images.masterworksfineart.com/design/masterworks-fine-art-logo-small.gif" alt="Masterworks Fine Art Gallery"></a></div>

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- <a class="navbar-brand" href="http://gemini.andrew.com">Gemini</a>-->
        </div>
        <div id="navbar-main" class="navbar-collapse collapse" style="position: relative">
            <ul class="nav navbar-nav">
                <li><a href="https://www.masterworksfineart.com/artists">Artists</a></li>
                <li><a href="https://www.masterworksfineart.com/about-us">About</a></li>
                <li><a href="https://www.masterworksfineart.com/contact-gallery">Contact</a></li>
                <li><a href="https://www.masterworksfineart.com/contact-gallery/membership-invitation" class="newsletter-nav" style="color: #004b91; text-transform: none !important; font-style: italic; text-decoration: underline;">Sign up for our newsletter to receive special sales and news!</a></li>
            </ul>
        </div><!--/.nav-collapse -->
        <form id="multiple-datasets-alpha" method="GET" action="https://www.masterworksfineart.com/" accept-charset="UTF-8" class="navbar-form navbar-right hidden-xs" role="search">
            <div class="input-group">
                <input class="typeahead form-control" placeholder="picasso, marc chagall, Cambell's Soup" autocomplete="off" name="s" type="text" id="s" aria-label="Search">
                <div class="input-group-btn">
                    <button class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
<!-- will be used to show any messages -->

<div class="container">
    <ol class="breadcrumb" style="margin-bottom: 0">
        <li><a href="https://www.masterworksfineart.com" title="Fine art original prints"><span class="glyphicon glyphicon-home"></span></a></li>
    </ol>
</div>

<div class="container">
    <?php GFFormDisplay::print_form_scripts( $form, false ); // ajax = false ?>
    <?php gravity_form( $form_id, $display_title, $display_description ); ?>
    <?php wp_footer(); ?>
</div>

<script>window.domain_url = 'www.masterworksfineart.com';</script><div class="container">
    <footer>
        <div class="row">
            <div class="col-md-4">
                <h3>Explore the Gallery</h3>
                <ul class="nav">
                    <li><a href="https://www.masterworksfineart.com">Home</a></li>
                    <li><a href="https://www.masterworksfineart.com/artists">Artists Represented</a></li>
                    <li><a href="https://www.masterworksfineart.com/fine-art-artists">Artists' Genres and Series</a></li>
                    <li><a href="https://www.masterworksfineart.com/art-prints-for-sale">Art Prints For Sale</a></li>
                    <li><a href="https://www.masterworksfineart.com/about-us">About the Gallery</a></li>
                    <li><a href="https://www.masterworksfineart.com/contact-gallery">Contact Us!</a></li>
                    <li><a href="https://shop.masterworksfineart.com/cart">Shopping Cart <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                    <li><a href="https://www.masterworksfineart.com/contact-gallery/how-to-sell-fine-art-you-own">Sell Your Fine Art</a></li>
                    <li><a href="https://news.masterworksfineart.com">Art News</a></li>
                    <li><a href="https://www.masterworksfineart.com/educational-resources/">Tools for Art Collecting</a></li>
                    <li><a href="https://www.masterworksfineart.com/about-us/fine-art-gallery-careers">Careers</a></li>
                    <li><a href="https://www.masterworksfineart.com/about-us/press">Press</a></li>
                    <li><a href="https://www.masterworksfineart.com/privacy-policy">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Our Customer Service</h3>
                <ul class="nav">
                    <li><a href="#">Always there for you</a></li>
                    <li><a href="#">The Certificate of Authenticity</a></li>
                    <li><a href="#">Historical Documentation</a></li>
                    <li><a href="#">100% Moneyback Guarantee</a></li>
                    <li><a href="#">Museum-Archival Framing</a></li>
                    <li><a href="#">Our Competitive Pricing</a></li>
                    <li><a href="#">Easy Payments</a></li>
                    <li><a href="#">Packaging and Insurance</a></li>
                    <li><a href="#">Free Annual Appraisal!</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Let's Get Social</h3>
                <ul class="nav navbar-nav">
                    <li><a href="https://www.facebook.com/masterworksfineartgallery" target="_blank"><img src="https://images.masterworksfineart.com/design/fb-icon.png" /></a></li>
                    <li><a href="https://twitter.com/masterworksfa"><img src="https://images.masterworksfineart.com/design/twitter-icon.png" /></a></li>
                    <li><a href="https://www.instagram.com/masterworksfineart/"><img src="https://images.masterworksfineart.com/design/instagram-icon.jpg" /></a></li>
                    <li><a href=""><img src="https://images.masterworksfineart.com/design/pinterest-icon.png" /></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Contact Us</h3>
                <ul class="nav">
                    <li><a href="#">What do you think of our gallery?</a></li>
                    <li>Email: <a href="mailto:info@masterworksfineart.com">info@masterworksfineart.com</a></li>
                    <li>Call: <div style="position: relative; display: block; padding: 10px 15px;"><a href="tel:510-777-9970" style="display: inline-block">510-777-9970</a> / <a href="tel:800-805-7060" style="display: inline-block">800-805-7060</a></div></li>
                    <li>Mail: <a href="https://goo.gl/maps/Pcq99SwRpbx" target="_blank">Masterworks Fine Art Gallery<br />
                            13470 Campus Drive<br />
                            Oakland Hills, California USA 94702</a></li>
                </ul>
            </div>
        </div>
    </footer>
</div>

<div class="container">
    <p class="text-muted" style="font-size: 1em">
        &copy; Masterworks Fine Art Gallery. All rights reserved. <a href="https://www.masterworksfineart.com/privacy-policy">Privacy Policy</a>. Our gallery is located in the beautiful Oakland Hills of the <b>San Francisco</b> Bay Area, California, USA.
    </p>
</div>

<link href="//www.masterworksfineart.com/css/app.3474eff73821bb1246635beb7f830e4c.css" rel="stylesheet">


<script src="//www.masterworksfineart.com/js/all.55ea53ceb1b63b2cbb7fed24f295e755.js"></script>
<script src="//www.masterworksfineart.com/vendor/typeahead.0.11.1.bundle.min.js"></script>
<script src="//www.masterworksfineart.com/js/search-typeahead.8bc32f702d1e54108060.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script', '//www.masterworksfineart.com/js/analytics.js','ga');

  ga('create', 'UA-3116235-1', 'auto');
  ga('send', 'pageview');

</script>


<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
  var sc_project=3759295;
  var sc_invisible=1;
  var sc_security="ab715bd5";
  var sc_https=1;
  var scJsHost = (("https:" == document.location.protocol) ?
    "https://secure." : "http://www.");
</script>
<script type="text/javascript"
        src="https://www.statcounter.com/counter/counter.js"
        async></script>
<noscript><div class="statcounter"><a title="Web Analytics
Made Easy - StatCounter" href="http://statcounter.com/"
                                      target="_blank"><img class="statcounter"
                                                           src="//c.statcounter.com/3759295/0/ab715bd5/1/" alt="Web
Analytics Made Easy - StatCounter"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->


<style>
    @media  print {

        .v4-tease,
        .navbar,
        .breadcrumb,
        #showcaser-hero,
        .related-artworks,
        .intro-header,
        .filters,
        footer {
            display: none;
        }

        a[href]:after {
            content: none !important;
        }

        .artworks {
            width: 33% !important;
            float: left;
        }
    }

    @page  {
        size: 8.5in 11in;
    }
</style>


</body>
</html>
