/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function popopen(content, subject, command){
	if (typeof (subject) == "undefined") subject = '';
	if (typeof (command) == "undefined") command = '<a onClick="popclose()">确定</a>';
	$(".tishitit").html(subject);
	$(".contents").html(content);
	$(".msgbtn").html(command);
	$(".tishi").show();
}
function tishi(content, subject, command){
	if (typeof (subject) == "undefined") subject = '';
	if (typeof (command) == "undefined") command = '<a onClick="popclose()">确定</a>';
	$(".tishitit").html(subject);
	$(".contents").html(content);
        $("#ceshi").removeClass("button_small");
        $("#ceshi").addClass("bxbutton1");
	$(".msgbtn").html(command);
	$(".tishi").show();
}
function popclose(){
	$(".tishi").hide();
}
$(".close").click(function(){
	$(".tishi").hide();
});

