<template>
  <div class="">
    <h4>Reportes del Venta Junio</h4>
    <canvas id="myChart" width="400" height="400"></canvas>
  </div>
</template>

<script>

var Grid = function(width, height) {

    this.draw = function() {
    var canvas = document.getElementById("canvas");
    if(canvas.getContext) {
        var context = canvas.getContext("2d");
        for(var i = 0; i < width; i++) {
            for(var j = 0; j < height; j++) {
                if(isLive(i, j)) {
                    context.fillStyle = "lightblue";
                }
                else {
                    context.fillStyle = "yellowgreen";
                }
                context.fillRect(i*15, j*15, 14, 14);
                }
            }
        }
    }
 }

</script>
