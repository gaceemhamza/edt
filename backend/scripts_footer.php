<script  type="text/javascript">
var header = document.getElementById("buttons_m");
var btns = header.getElementsByClassName("index_list");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  this.className += " active";
  });
  console.log("hola");
}
</script>

<script  type="text/javascript">
window.onscroll = function() {myFunction()};

var header = document.getElementById("header_index");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
<script>
$(document).ready(function(){
  $("#myBtn").click(function(){
    $("#myModal").modal();

  });
});
</script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<!-- <script>
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("logout").style.top = "114px";
  } else {
    document.getElementById("logout").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}
</script> -->
