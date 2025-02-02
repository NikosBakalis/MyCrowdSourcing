<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="footer">
      <div class="footer_content">
        <div class="footer_section about">
          <h1 class="logo_text"><span>MY</span>CROWDSOURCING<span>.</span>COM</h1>
          <p>
            is a sourcing model in which users
            are allowed to upload their Google
            Location History JSON from:
            <a  href="https://takeout.google.com"> Here </a>
            <br>After that all of your data will be
            displayed in our maps.<br>
            Feal free to visit:
            <a href="services.php">Services</a>
            for further info.
          </p>
          <div class="contact">
            <span><i class="fa fa-phone"></i> &nbsp; 6982063681</span>
            <span><i class="fa fa-envelope"></i> &nbsp; bakalis.nikolas@gmail.com</span>
          </div>
          <div class="socials">
            <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
            <a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a>
            <a href="https://www.twitter.com/"><i class="fa fa-twitter"></i></a>
            <a href="https://www.youtube.com/"><i class="fa fa-youtube"></i></a>
            <a href="https://github.com/NikosBakalis/MyCrowdSourcing"><i class="fa fa-github"></i></a>
          </div>
        </div>
        <div class="footer_section links">
          <h2>Quick Links</h2>
          <br>
          <ul>
            <a href="#"><li>Events</li></a>
            <a href="#"><li>Team</li></a>
            <a href="#"><li>Terms and Conditions</li></a>
          </ul>
        </div>
        <div class="footer_section contact_form">
          <h2>Contact us</h2>
          <br>
          <form action="index.html" method="post">
            <input type="email" name="email" class="text_input contact_input" placeholder="Your email address..."></input>
            <textarea name="message" class="text_input contact_input" placeholder="Your message..."></textarea> <!--  This one right here has to limit its length and width size with JavaScript. -->
            <!-- This one right below will be usefull. -->
            <!-- https://stackoverflow.com/questions/4459610/set-maxlength-in-html-textarea -->
            <button type="submit" name="button" class="btn btn_big contact_btn">
              <i class="fa fa-envelope"></i>
              Send
            </button>
          </form>
        </div>
      </div>
      <div class="footer_copyright">
        &copy; mycrowdsourcing.com | Designed by Team Extream
      </div>
    </div>
  </body>
</html>
