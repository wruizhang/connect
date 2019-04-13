// JavaScript Document

/**
 This function display user comments and stores a cookie on the page
 @param {String} id of the cookie
 @param {String} name of the user
 @param {String} message content
 @param {String} timestamp 
 @return n/a
*/
function display_comment(id, name, content, time){
	makeCookie(id, name, content, time);
	let container = 'all_the_comments'+id;
	document.getElementById(container).innerHTML += id;
	let br1 = document.createElement('br');
	document.getElementById(container).appendChild(br1);
	document.getElementById(container).innerHTML += content;
}

/**
 This function makes a cookie that stored the id, name, content, and timestamp of a post
 @param {String} id of the cookie
 @param {String} name of the user
 @param {String} message content
 @param {String} timestamp 
 @return n/a
*/
function makeCookie(id, name, content, time){
	let id = id;
	let username = name;
	let post_time = time;
	let post = content; 
	let cookie_id = "id=" + id + ";";
	let cookie_name = "name= " + username + ";";
	let cookie_time_stamp = "time= " + post_time + ";";
	let cookie_content = "content= " + content + ";";
	
	let duration = new Date();
	duration.setTime(duration.getTime() + (10 * 1000));
	let cookie_expires = "expires=" + duration.toUTCString() + ";";
	let cookie_path = "path=/;";
	document.cookie = cookie_id + cookie_expires + cookie_path;
	document.cookie = cookie_name + cookie_expires + cookie_path;
	document.cookie = cookie_time_stamp + cookie_expires + cookie_path;
	document.cookie = cookie_content + cookie_expires + cookie_path;
	
}


/**
 This function gets the value stored in a cookie
 
 @param {String} name of the cookie

 @return {String} value associated w/ cookie
*/
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i < ca.length; i++) { 
   	let c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length);
		
    }
  }
  return "";
}