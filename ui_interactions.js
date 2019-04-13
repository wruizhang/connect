
/**
 This function uses jQuery to control the display (content and color) of the introduction text
 
@param n/a
@param n/a

@return n/a
*/
$(document).ready(
	function(){
		$('.hoverSiteName').mouseenter(function(){
			$(this).text("a collaboration forum");
			$(this).css('color', "#A569BD");
			$(this).text().fadeIn();
		});
		
		$('.hoverSiteName').mouseleave(function(){
			$(this).text("connect");
			$(this).css('color', "#48C9B0");
			$(this).text().fadeIn();
		});
		
		$('.hoverPeople').mouseenter(function(){
			$(this).text("creative minds");
			$(this).css('color', "#A569BD");
			$(this).text().fadeIn();
		});
		
		$('.hoverPeople').mouseleave(function(){
			$(this).text("students");
			$(this).css('color', "#48C9B0");
			$(this).text().fadeIn();
		});
		
	}
);


/**
 This function hides and shows the login page
 
@param n/a
@param n/a

@return n/a
*/
function login(){
	document.getElementById('login').style.display = 'block'; 
	document.getElementById('register').style.display = 'none';
}

/**
 This function hides and shows the sign up page
 
@param n/a
@param n/a

@return n/a
*/
function signup(){
	document.getElementById('register').style.display = 'block'; 
	document.getElementById('login').style.display = 'none';
}
