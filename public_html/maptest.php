<!DOCTYPE html>
<meta charset="utf-8">
<style>

/* CSS goes here. */

</style>
<body>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://d3js.org/topojson.v1.min.js"></script>
<script>

var gssCode = "S12000040";
var mapjson = gssCode + "_topo.json";

var width = 960,
    height = 1160;

var projection = d3.geo.albers()
    .center([0, 55.4])
    .rotate([4.4, 0])
    .parallels([50, 60])
    .scale(6000)
    .translate([width / 2, height / 2]);

var path = d3.geo.path()
    .projection(projection);

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height);

d3.json(mapjson, function(error, councilArea) {
  svg.append("path")
      .datum(topojson.feature(councilArea, councilArea.objects[gssCode + "_geo"]))
      .attr("id", "council_area")
      .attr("d", path);
});

</script>
</body>