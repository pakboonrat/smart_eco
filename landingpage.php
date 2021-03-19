<html lang="en" class="pc chrome88 js">




<head>
<meta charset="UTF-8">
<title>A Pen by Pak Boonrat</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.14.2/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/ScrollMagic.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/plugins/animation.gsap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/plugins/debug.addIndicators.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.js"></script>
<script>
// Add active class to current nav selected link
var a = document.querySelectorAll(".navbar li a");
for (var i = 0, length = a.length; i < length; i++) {
  a[i].onclick = function() {
    var b = document.querySelector(".navbar li.active");
    if (b) b.classList.remove("active");
    this.parentNode.classList.add('active');
  };
}

// Color palette variables
let dark = '#252525';
let mid = '#888';
let light = 'rgba(255, 255, 255, 0.4)';

// Add scrollmagic controller
let controller = new ScrollMagic.Controller();

//------------------
//TIMELINE 1
//------------------

// Add timeline
let tl1 = anime.timeline({autoplay: false});

// Add animations
let s1a1 = {
  targets: '#one .elem',
  opacity: 1,
  translateX: {
    value: [250, 0],
    duration: 800
  },
  rotate: {
    value: [90, 0],
    duration: 1200,
    easing: 'easeInOutSine'
  },
  scale: {
    value: [2, 1.5],
    duration: 1100,
    delay: 800,
    easing: 'easeInOutQuart'
  },
  color: [light, dark],
  duration: 800,
  delay: 0,
  easing: 'easeInOutSine'
};

let s1a2 = {
  targets: '#one .elem .blocks > div',
  backgroundColor: [light, dark],
  borderRadius: function(el) { return anime.random(2, 10); },
  delay: function(el) { return anime.random(0, 800); }
};

let s1a3 = {
  targets: '#one .rectangle',
  opacity: [0,1],
  translateX: {
    value: ['-100vw', '0vw'],
    duration: 1500,
  },
  translateY: {
    value: [-100, 0],
    duration: 1500,
  },
  easing: 'easeInOutSine',
  duration: 2000
};

// Add children
tl1.add(s1a3).add(s1a1, '-=1600').add(s1a2, '-=1300');

// Get section height
let oneHeight = document.getElementsByClassName("one")[0].clientHeight;
console.log('oneHeight: ' + oneHeight);

//------------------
//SCENE 1
//------------------

//Add first scrollmagic scene
let scene1 = new ScrollMagic.Scene({
  triggerElement: "#one",
  triggerHook: 0.5,
  reverse: false
})

// Add debug indicators
.addIndicators({
  colorTrigger: "black",
  colorStart: "blue",
  colorEnd: "red",
  indent: 10
})

// Trigger animation timeline
.on("enter", function (event) {
  tl1.play();
})
  
.addTo(controller);



//------------------
//TIMELINE 2
//------------------

// Add timeline
let tl2 = anime.timeline({autoplay: false});

// Add animations
let s2a1 = {
  targets: '#two .elem img',
  opacity: [0.3,1],
  scale: [4,1],
  duration: 1000,
  delay: 0,
  easing: 'easeInOutSine'
};

let s2a2 = {
  targets: '#two .elem img',
  scale: 1,
  duration: 2000,
};

// Add children
tl2.add(s2a1).add(s2a2);

// Get section height
let twoHeight = document.getElementById("two").clientHeight;
console.log('twoHeight: ' + twoHeight);

//------------------
//SCENE 2
//------------------

//Add second scrollmagic scene
let scene2 = new ScrollMagic.Scene({
  triggerElement: "#two",
  duration: 4500,
  triggerHook: 0,
})

// Add debug indicators
.addIndicators({
  colorTrigger: "black",
  colorStart: "blue",
  colorEnd: "red",
  indent: 10
})

// Trigger animation timeline
//Use scroll position to play animation
.on("progress", function (event) {
  tl2.seek(tl2.duration * event.progress);
})

.setPin('#two')
.addTo(controller);



//------------------
//TIMELINE 3
//------------------

// Add timeline
let tl3 = anime.timeline({autoplay: false});

// Add animations
let s3a1 = {
  targets: '#three h2',
  opacity: 1,
  scale: [4,1.5],
  duration: 1000,
  delay: 0,
  easing: 'easeInOutSine'
};

// Add children
tl3.add(s3a1);

//------------------
//TIMELINE 4
//------------------

// Add timeline
let tl4 = anime.timeline({autoplay: false});

// Add animations
let s3a2 = {
  targets: '#three .image',
  opacity: [0,.5],
  translateX: {
    value: ['-100%', '0%'],
    duration: 1500,
  },
  duration: 1000,
  delay: 0,
  easing: 'easeInOutSine'
};

// Add children
tl4.add(s3a2);

//------------------
//SCENE 3
//------------------

//Add third scrollmagic scene
let scene3 = new ScrollMagic.Scene({
  triggerElement: "#three",
  duration: 2000,
  triggerHook: 0
})

// Add debug indicators
.addIndicators({
  colorTrigger: "black",
  colorStart: "blue",
  colorEnd: "red",
  indent: 10
})

// Trigger animation timeline
//Use scroll position to play animation
.on("enter", function (event) {
  tl3.play();
})
.on("progress", function (event) {
  tl4.seek((tl4.duration * event.progress) * 3);
})

.setPin('#three')
.addTo(controller);




//------------------
//TIMELINE 5
//------------------

// Add timeline
let tl5 = anime.timeline({autoplay: false});

// Add animations
let s4a1 = {
  targets: '#four h2',
  opacity: 1,
  scale: [1.5,3],
  duration: 1000,
  delay: 0,
  easing: 'easeInOutSine'
};

// Add children
tl5.add(s4a1);

//------------------
//TIMELINE 6
//------------------

// Add timeline
let tl6 = anime.timeline({autoplay: false});

// Add animations
let s4a2 = {
  targets: '#four .image',
  opacity: [0,.5],
  translateX: {
    value: ['100%', '0%'],
    duration: 1500,
  },
  duration: 1000,
  delay: 0,
  easing: 'easeInOutSine'
};

// Add children
tl6.add(s4a2);

//------------------
//SCENE 4
//------------------

//Add third scrollmagic scene
let scene4 = new ScrollMagic.Scene({
  triggerElement: "#four",
  duration: 2000,
  triggerHook: 0
})

// Add debug indicators
.addIndicators({
  colorTrigger: "black",
  colorStart: "blue",
  colorEnd: "red",
  indent: 10
})

// Trigger animation timeline
//Use scroll position to play animation
.on("enter", function (event) {
  tl5.play();
})
.on("progress", function (event) {
  tl6.seek((tl6.duration * event.progress) * 3);
})

.setPin('#four')
.addTo(controller);

</script>
<style >
    body {
  padding-top: 56px;
  font-weight: 300;
  letter-spacing: 0.03em;
  background-color: #f7f7f7;
}

nav.navbar {
  border-bottom: solid 1px #d6d6d6;
}

.navbar .navbar-brand {
  font-weight: 500;
  letter-spacing: .065em;
}


.navbar-nav .nav-link {
    letter-spacing: .035em;
}

.navbar li.active a {
  font-weight: 400;
}

main.container-fluid {
  padding-left: 0;
  padding-right: 0;
}

.spacer {
  height: 40vh;
}

.rectangle {
  position: absolute;
  width: 97vw;
  height: 30vw;
  border-radius: 10px;
  background: linear-gradient(45deg, #69b7bf 25%, #ffe664);
}

@media (min-width: 500px) {
  .rectangle {
    width: 80%;
  }
}

.section > .row > .col {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-content: center;
  align-items: center;
}

#intro .col {
  height: 50vh;
  padding: 9vw 6vw;
  font-size: 18px;
}

@media (min-width: 1000px) {
  #intro .col {
    padding: 18vw 12vw;
    font-size: 2.7vw;
  }
}

#one {
  background-color: #212121;
}

#one .elem {
  opacity: 0;
  letter-spacing: 0.04em;
}

#one .text-block h2 {
  font-size: 5vw;
  letter-spacing: 0.2em;
  font-weight: 300;
  line-height: 1;
}

#one .text-block h5 {
  font-size: 4vw;
  line-height: 1;
}

#one .elem .blocks {
  display: flex;
  justify-content: space-between;
  align-content: center;
  align-items: center;
}

#one .elem .blocks > div {
  height: 20px;
  width: 20px;
  margin: 2px;
  border-radius: 2px;
  background-color: #333;
}

#two {
  height: auto;
  overflow: hidden;
  padding: 3vw 15vw 10vw;
  background: linear-gradient(0deg, #69b7bf 25%, #ffe664);
}

#three, #four {
  position: relative;
  overflow: hidden;
}

#three .image, #four .image {
  position: absolute;
  top: 0;
  bottom:0;
  width: 100%;
}

#three .image {
  background-image: url("https://drive.google.com/uc?export=view&id=10tzeBrvoR5OO3EK_Wcg-gRxbVO7xv6em");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}

#four .image {
  background-image: url("https://drive.google.com/uc?export=view&id=1SzCTDu5_eAF569lFHtNyIlUCrdW2mOXu");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}

  </style>

</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
      <a class="navbar-brand" href="#">START</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#one">Section 1</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#two">Section 2</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#three">Section 3</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#four">Section 4</a>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="container-fluid">
      <div class="row no-gutters">
        <div class="col text-center">
          <h1 class="py-5">SCROLL DOWN TO TRY ANIMATIONS</h1>
          <img
            src="https://drive.google.com/uc?export=view&id=1g2iw0lEBMYFyKjI9A1jN2wm0glHiXubt"
            class="img-fluid"
            alt="Responsive image"
          />
        </div>
      </div>
      <section id="intro" class="section">
        <div class="row no-gutters">
          <div class="col">
            <div>
              The Neuron scales the steepest climbs and descends with complete
              control thanks to its 130 - 140mm suspension, 29” wheels (in sizes
              M-XL) and confidence-inspiring geometry.
            </div>
          </div>
        </div>
      </section>
      <section id="one" class="section">
        <div class="row no-gutters">
          <div class="col">
            <div class="rectangle"></div>
            <div class="elem">
              <div class="text-block">
                <h2 class="mb-0">2021</h2>
                <h5>Neuron CF SLX 9</h5>
              </div>
              <div class="blocks">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="two" class="section">
        <div class="row no-gutters">
          <div class="col">
            <div class="elem">
              <div>
                <img
                  src="https://drive.google.com/uc?export=view&id=1wx3G8XcML7t9hTiE1ioUkLUiqUHkI_AJ"
                  class="img-fluid"
                  alt="Responsive image"
                />
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="three" class="section">
        <div class="image"></div>
        <div class="row no-gutters">
          <div class="col">
            <div class="elem">
              <h2>GET OUT THERE</h2>
            </div>
          </div>
        </div>
      </section>
      <section id="four" class="section">
        <div class="image"></div>
        <div class="row no-gutters">
          <div class="col">
            <div class="elem">
              <h2>GO RIDE</h2>
            </div>
          </div>
        </div>
      </section>
    </main>
    </body>
    </html>
