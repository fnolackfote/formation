/**
 * Created by fnolackfote on 17/03/2016.
 */

function generatepage() {
    $(document).ready(function() {
        $.ajax({
            url : '/../App/Frontend/Config/routes.xml'
        })
    });
}
/*$(document).ready(function(e){
 $.ajax({
     url: '../Config/routes.xml',
     types: 'GET',
     dataType: 'xml',
     success: function(xml) {
     $(xml).find('route').each(function() {
     var myfile = $(this).attr('outfile');
     var link = $(this).attr('url');
     $.ajax({
     url: link,
     dataType: 'json';
     })
    })
    }
 });
 return false;
 });*/

/*$(document).ready(function(e){
 $.ajax({
 url : <?= $this ?>,
 dataType: 'json',
 type: 'GET';
 })
 });*.

 /*$('nav ul li a').click(function(e){
 var url = $(this).attr('href');
 alert(url);
 $.ajax({
 url: url,
 success: function(text){
 $('#main').html($'#main').html(text);
 }
 });
 return false;
 });*/