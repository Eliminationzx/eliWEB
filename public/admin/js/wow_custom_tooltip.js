$(document).ready(function() {
  $('wow-tooltip-content').hover(function() { 
    $('<div class="tooltip-wowitem-content"><p>'  
    + '<span style="Color:' + this.dataset.shopitemQualityColor + '">' + this.dataset.shopitemName + '</span>'
    + '<span>' + this.dataset.shopitemBonding + '</span>'
    + '<span>' + this.dataset.shopitemInvtype + '</span>'
    + '<span>' + this.dataset.shopitemArmor + '</span>'
    + '<span>' + this.dataset.shopitemDmg_min1 + '</span>'
    + '<span>' + this.dataset.shopitemDmg_min2 + '</span>'
    + '<span>' + this.dataset.shopitemDelay + '</span>'
    + '<span>' + this.dataset.shopitemDmgpersec + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue1 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue2 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue3 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue4 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue5 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue6 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue7 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue8 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue9 + '</span>'
    + '<span>' + this.dataset.shopitemMainStatvalue10 + '</span>'
    + '<span>' + this.dataset.shopitemSkill + '</span>'
    + '<span>' + this.dataset.shopitemMaxdurability + '</span>'
    + '<span>' + this.dataset.shopitemItemlevel + '</span>'
    + '<span>' + this.dataset.shopitemRequiredlevel + '</span>'
    + '<span>' + this.dataset.shopitemAllowableclass + '</span>'
    + '<span>' + this.dataset.shopitemAllowablerace + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue1 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue2 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue3 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue4 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue5 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue6 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue7 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue8 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue9 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemBonusStatvalue10 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemSpell1 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemSpell2 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemSpell3 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemSpell4 + '</span>'
    + '<span style="color:#1EFF00">' + this.dataset.shopitemSpell5 + '</span>'
    + '</p></div>').appendTo('body').fadeIn('slow');
  }, function() { 
    $('.tooltip-wowitem-content').remove();
  }).mousemove(function(e) {
     var mousex=e.pageX+20,mousey=e.pageY+10,
     $tooltip=$('.tooltip-wowitem-content'),
     wW=$(window).scrollLeft()+$(window).width(),
     wH=$(window).scrollTop()+$(window).height();
     
     mousex+$tooltip.outerWidth() > wW && (mousex=wW-$tooltip.outerWidth()),
     mousey+$tooltip.outerHeight() >wH && (mousey=e.pageY-$tooltip.outerHeight()-10),
     $('.tooltip-wowitem-content').css({top:mousey,left:mousex})
  });
    $('wow-tooltip-charinfo-content').hover(function() { 
    $('<div class="tooltip-wowitem-content"><p>' +
    '<span>' + this.dataset.charinfoFaction + '</span>'	+
	'<span>' + this.dataset.charinfoRace + '</span>'	+
	'<span>' + this.dataset.charinfoClass + '</span>'	+
	'<span>' + this.dataset.charinfoLevel + '</span>'	+
	'<span>' + this.dataset.charinfoGold + '</span>'	+
	'<span>' + this.dataset.charinfoPlaytime + '</span>'	+
	'</p></div>').appendTo('body').fadeIn('slow');
  }, function() { 
    $('.tooltip-wowitem-content').remove();
  }).mousemove(function(e) {
     var mousex=e.pageX+20,mousey=e.pageY+10,
     $tooltip=$('.tooltip-wowitem-content'),
     wW=$(window).scrollLeft()+$(window).width(),
     wH=$(window).scrollTop()+$(window).height();
     
     mousex+$tooltip.outerWidth() > wW && (mousex=wW-$tooltip.outerWidth()),
     mousey+$tooltip.outerHeight() >wH && (mousey=e.pageY-$tooltip.outerHeight()-10),
     $('.tooltip-wowitem-content').css({top:mousey,left:mousex})
  });
});