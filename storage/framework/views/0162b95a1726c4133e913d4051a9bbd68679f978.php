

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Prueba tu suerte</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Inicio</a>
                </li> 
                <li class="active">
                    <strong>Prueba tu suerte</strong>
                </li> 
            </ol>
        </div>
    </div>
	
	<div class="chat-message left">
        <div class="message">
		    <h2>Información del juego</h2>
            <div class="alert alert-info" >
				   <ol>
					<li>Costo de giro - <?php echo e($spin_cost->value); ?> D</li>
					<li>Recompensa máxima "Ganancias legendarias" - <?php echo e($spin_reward->value * 10); ?> D</li>
					<li>Recompensa mínima - <?php echo e($spin_reward->value); ?> D</li>
					<li>Términos de juego:
						<ul>
							<li>Coincidencia de tres taurens ETC = GANANCIA LEGENDARIA (<?php echo e($spin_reward->value * 10); ?> D)</li>
							<li>Coincidencia de dos Taurens ETC + cualquier tercer puesto = ganar (<?php echo e($spin_reward->value * 2); ?> D)</li>
							<li>Coincidencia de un Tauren ETC + dos ranuras iguales = ganancias mínimas (<?php echo e($spin_reward->value); ?> D)</li>
							<li>Hacer coincidir tres ranuras iguales (excepto ETC Tauren) = ganancias mínimas (<?php echo e($spin_reward->value); ?> D)</li>
						</ul>
					</li>
				   </ol>
            </div>
		</div>	
		<div class="spin-box animated fadeInRight">
			<div id="status"><status>PRUEBA TU SUERTE</status> <img src="<?php echo e(URL::asset('admin/js/spin/icons/audioOn.png')); ?>" id="audio" class="option1" onclick="toggleAudio()" /></div>
			<div id="Slots">
				<?php for($i=1; $i <= 3; $i++): ?>
					<div id="slot<?php echo e($i); ?>" class="a1"></div>
				<?php endfor; ?>
			</div>
			<div class="infos">
				 <span id="spininfo"><spininfo>0</spininfo> <i class="fa fa-refresh fa-1x"></i></span>
				 <span id="wininfo"><wininfo>0</wininfo> <i class="fa fa-star fa-1x"></i></span>
				 <span id="superwininfo"><superwininfo>0</superwininfo> <i class="fa fa-star fa-1x"></i><i class="fa fa-star fa-1x"></i><i class="fa fa-star fa-1x"></i></span>
				 <span id="donateinfo"><donateinfo><?php echo e($data->donate); ?></donateinfo> D</span>
			</div>
			<div class="btn-spin" id="spinbtn" onclick="doSpin();">GIRAR!</div>
		</div>
    </div>
<script>
var max_slots = 3;
var doing = false;
var spin = [
new Audio("../admin/js/spin/sounds/spin.mp3"),
new Audio("../admin/js/spin/sounds/spin.mp3"),
new Audio("../admin/js/spin/sounds/spin.mp3"),
new Audio("../admin/js/spin/sounds/spin.mp3"),
new Audio("../admin/js/spin/sounds/spin.mp3"),
new Audio("../admin/js/spin/sounds/spin.mp3"),
new Audio("../admin/js/spin/sounds/spin.mp3")
];
var coin = [
new Audio("../admin/js/spin/sounds/coin.mp3"),
new Audio("../admin/js/spin/sounds/coin.mp3"),
new Audio("../admin/js/spin/sounds/coin.mp3")
]
var win = new Audio("../admin/js/spin/sounds/win.mp3");
var winspecial = new Audio("../admin/js/spin/sounds/winspecial.mp3");
var winsuper = new Audio("../admin/js/spin/sounds/winsuper.mp3");
var lose = new Audio("../admin/js/spin/sounds/lose.mp3");
var audio = false;

let status = document.querySelector("status")
let spinbtn = document.getElementById("spinbtn");

let donateinfo = document.querySelector("donateinfo");
let spininfo = document.querySelector("spininfo");
let wininfo = document.querySelector("wininfo");
let superwininfo = document.querySelector("superwininfo");

var spincounter = 0; 
var superwincounter = 0;
var wincounter = 0;

function doSpin(){
    if (doing) {return null;}

    this.sendpost('/personal/spin/pay', null, null, resp => doSlot(resp));
}

function doSlot(resp){
    if (doing) {return null;}
    
    var token = resp.token;
    var donate = resp.donate;
    var reward = resp.reward;
    var price = resp.price;
    var allow = resp.allow;
    
    if (!allow)
    {
       spinbtn.innerHTML = 'There are not enough funds in your account, top up your balance!';
       return null;
    }
    
    doing = true;
    
    spinbtn.innerHTML = 'DO SPIN';
    
	var numChanges = randomInt(1,4)*7
	var numeberSlot1 = numChanges+randomInt(1,7)
	var numeberSlot2 = numChanges+2*7+randomInt(1,7)
	var numeberSlot3 = numChanges+4*7+randomInt(1,7)
  
	var i1 = 0;
	var i2 = 0;
	var i3 = 0;
	var sound = 0;
    
	status.innerHTML = 'SPIN...';
    
    donateinfo.innerHTML = donate;
    spininfo.innerHTML = ++spincounter;

	slot1 = setInterval(spin1, 50);
	slot2 = setInterval(spin2, 50);
	slot3 = setInterval(spin3, 50);
       
	function spin1(){
		i1++;
		if (i1>=numeberSlot1){
			coin[0].play()
			clearInterval(slot1);
			return null;
		}
		slotTile = document.getElementById('slot1');
		if (slotTile.className=='a7'){
			slotTile.className = 'a0';
		}
		slotTile.className = "a"+(parseInt(slotTile.className.substring(1))+1)
	}
	function spin2(){
		i2++;
		if (i2>=numeberSlot2){
			coin[1].play()
			clearInterval(slot2);
			return null;
		}
		slotTile = document.getElementById('slot2');
		if (slotTile.className == 'a7'){
			slotTile.className = 'a0';
		}
		slotTile.className = "a"+(parseInt(slotTile.className.substring(1))+1)
	}
	function spin3(){
		i3++;
		if (i3>=numeberSlot3){
			coin[2].play()
			clearInterval(slot3);
            testWin(reward, price);
			return null;
		}
		slotTile = document.getElementById('slot3');
		if (slotTile.className == 'a7'){
			slotTile.className = 'a0';
		}
		sound++;
		if (sound==spin.length){
			sound=0;
		}
		spin[sound].play();
		slotTile.className = "a"+(parseInt(slotTile.className.substring(1))+1)
	}
}

function testWin(reward, price) {
    var sound = null;
    var status_text = null;
    
    if (getspecialcount() == max_slots) {
        reward = reward * 10;
        status_text = '<span class="spin-superwin">YOU WON ' + reward + ' DONATION POINTS!</span>';
		sound = winsuper;
        ++superwincounter;
    }
    else if (getspecialcount() == 2)   
    {
    	reward = reward;
        status_text = '<span class="spin-win">YOU WON ' + reward + ' DONATION POINTS!</span>';
		sound = win;
        ++wincounter;
    }
    else if (slotequals()) {
        reward = reward * 2;
        status_text = '<span class="spin-win">YOU WON ' + reward + ' DONATION POINTS!</span>';
		sound = win;
        ++wincounter;
    } else {
        reward = 0;
        status_text = '<span class="spin-lose">FAIL!</span>';
        sound = lose;
    }
    
    status.innerHTML = status_text;
    sound.play();
    
    if (reward > 0) {
        var donate = parseInt(donateinfo.innerHTML, 10);
        donateinfo.innerHTML = (donate + reward) + '<span class="spin-win"> (+' + reward + ')</span>';
        wininfo.innerHTML = wincounter;
        superwininfo.innerHTML = superwincounter;
    
        sendpost('/personal/spin/reward', token);
    } else
    {
        var donate = parseInt(donateinfo.innerHTML, 10);
        donateinfo.innerHTML = donate + '<span class="spin-lose"> (-' + price + ')</span>';
    }
    
	doing = false;
}

function sendpost(url, token, params = null, callback = null) {
    var http = new XMLHttpRequest();
    
    if (callback != null) {
        http.onreadystatechange = (e) => {
            if(http.readyState == 4 && http.status == 200) {
                callback(JSON.parse(http.responseText));
            }
        };
    }
    
    http.open('POST', url, true);
    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.setRequestHeader('X-CSRF-TOKEN', document.head.querySelector('[name=csrf-token]').content );
    http.setRequestHeader('SpinToken', token);
    http.send(params);
}

function slotequals(){  
    var slots = [];   
    var i;
    var slotval;
    for(i= 0; i < max_slots; i++) {
        slotval = document.getElementById('slot'+(i+1)).className;
        
        if (slotval == "a7")
            continue;

        slots.push(slotval);
    }
    
    return slots.every((val, i, arr) => val === arr[0]) && slots.length == max_slots;
}

function getspecialcount() {
    var i;
    var count = 0;
    for(i=1; i <= max_slots; i++) {
        if (document.getElementById('slot'+i).className == 'a7')
            count++;                 
    }
    return count;
}

function toggleAudio(){
	if (!audio){
		audio = !audio;
		for (var x of spin){
			x.volume = 0.5;
		}
		for (var x of coin){
			x.volume = 0.5;
		}
		win.volume = 1.0;
        winspecial.volume = 1.0;
        winsuper.volume = 1.0;
		lose.volume = 1.0;
	}else{
		audio = !audio;
		for (var x of spin){
			x.volume = 0;
		}
		for (var x of coin){
			x.volume = 0;
		}
		win.volume = 0;
        winspecial.volume = 0;
        winsuper.volume = 0;
		lose.volume = 0;
	}
	document.getElementById('audio').src = '../admin/js/spin/icons/audio'+(audio?"On":"Off")+'.png';
}

function randomInt(min, max){
	return Math.floor((Math.random() * (max-min+1)) + min);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>