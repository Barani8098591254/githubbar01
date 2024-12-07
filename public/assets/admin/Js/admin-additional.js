


  document.addEventListener("DOMContentLoaded", function() {
    display_pattern();
    // Add an event listener for the reset button
    // document.getElementById("resetPatternBtn").addEventListener("click", reset_pattern);
  });

  function display_pattern() {
    var lock = new PatternLock('#pattern1', {
      onDraw: function(pattern) {
        console.log('Pattern Drawn:', pattern);
        document.getElementById("pattern_val").value = pattern;
      }
    });
  }
  // Function to reset the pattern
  function reset_pattern() {
    var lock = new PatternLock('#pattern1');
    lock.reset(); // Reset the pattern
    document.getElementById("pattern_val").value = ""; // Clear the pattern value
  }





    // document.addEventListener("DOMContentLoaded", function() { display_pattern();});
    // function display_pattern()
    // {
    // var lock= new PatternLock('#pattern1',{
    //     onDraw:function(pattern){
    //       console.log('old patter--->',pattern);
    //         document.getElementById("pattern_val").value=lock.getPattern();

    //     }
    // });
    // }
