let particles = [];
let canvas;
let particle_params = {
	max_particles: 20
};


function setup(){
	canvas = createCanvas(windowWidth, windowHeight);
	canvas.position(0, 0);
	canvas.style('z-index', '-1');
//	stroke(255);
//	strokeWeight(2);
	

}

function draw(){
	
	canvas = createCanvas(windowWidth, windowHeight);
	background(200);
	//if(particles.length <= particle_params.max_particles){
//	let x = random(windowWidth);
//	let y = random(windowHeight);
//	particles.push(new Particle(x, y));
//		
//	for (let p of particles){
//		p.update();
//		p.display();
//	}
	//}
}
//function show_particles(){
//
//}
//function Particle(x, y){
//	this.position = createVector(x, y);
//	this.velocity = createVector(0, random(-4, 4));
//	this.size = random(2, 4);
//}
//
//Particle.prototype.display = function(){
//	ellipse(this.x, this.y, this.size);
//};
//
//Particle.prototype.update = function(){
//	this.position.add(this.velocity);
//};