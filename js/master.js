$(function(){
  SetRibbon();
  //CreateBreadcrumbs();

  //CLICKS
  $('#catagories ul li').click(function(){ //CLICK A TAG TO SEARCH
    SearchByTag($(this).text());
  });
  $('#crop').click(function() {
    var top = $('#box').position().top;
    var left = $('#box').position().left;
    var width = $('#box').width();
    var height = $('#box').height();
    $.post('profile-picture.php', {
      top:top, left:left, height:height, width:width},
      function() {
      window.location.replace("profile-picture.php");
    });
  });
  $('#generateBitcoinWallet').click(function(){
    //var test = GenerateBitcoinWallet();
  });
  $('#generateEthereumWallet').click(function(){
    //var test = GenerateEthereumWallet();
  });

  //ELEMENTS/CLASSES/IDENTIFIERS
  $('.accordion').each(function(){
    $(this).find('ol').addClass('options');
    $(this).find('ul').addClass('options');

    var m = $(this), n = 1;

    $(m).find('p:first-child').addClass('active');
    $(m).find('div:nth-child(2)').addClass('active');
    $(m).find('> p').each(function(){
      $(this).attr('id', 'acc-' + n).addClass('head');
      n++;
    });

    n = 1;

    $(m).find('div').each(function(){ //Assignment of ID's to content
      $(this).attr('id', 'acc-' + n);
      n++;
    });

    $(m).find('p.head').click(function(){ //Select Tab
      m = $(this);
      var mV = $(m).attr('id'),
          mPO = $(m).parent();

      if ($(m).hasClass('active') == true) {
        $(m).removeClass('active');
        $(mPO).find('div').removeClass('active');
      }
      else {
        $(mPO).find('p.head').removeClass('active'); //Deactivate other tabs
        $(m).addClass('active'); //Activate clicked tab
        $(mPO).find('div').each(function(){ //Selects content for active tab
          var mCV = $(this).attr('id');

          if (mV == mCV) {
            $(this).addClass('active');
          }
          else {
            $(this).removeClass('active');
          }
        });
      }
    });
  });
  $('.tabs').each(function(){
    $(this).find('ol').addClass('options');
    $(this).find('ul').addClass('options');

    var m = $(this), n = 1, x = $(m).find('.options').children().length, y = 100 / x, z = y.toString() + '%'; //Instanziation of variables; m for this, n for unknown integer, x and y and z for calculating and assigning a width to the children of the options list
    $(m).find('li:first-child').addClass('active');
    $(m).find('div:nth-child(2)').addClass('active');
    $(m).find('li').each(function(){ //Assignment of ID's to the options list items
      $(this).css('width', z).attr('id', 'tab-' + n);
      n++;
    });

    n = 1;

    $(m).find('div').each(function(){ //Assignment of ID's to content
      $(this).attr('id', 'tab-' + n);
      n++;
    });

    $(m).find('li').click(function(){ //Select Tab
      m = $(this);
      var mV = $(m).attr('id'),
          mPO = $(m).parent(),
          mPT = $(m).parent().parent();

      if ($(m).hasClass('active') == true) {
        $(m).removeClass('active');
        $(mPT).find('div').removeClass('active');
      }
      else {
        $(mPO).find('li').removeClass('active'); //Deactivate other tabs
        $(m).addClass('active'); //Activate clicked tab
        $(mPT).find('div').each(function(){ //Selects content for active tab
          var mCV = $(this).attr('id');

          if (mV == mCV) {
            $(this).addClass('active');
          }
          else {
            $(this).removeClass('active');
          }
        });
      }
    });
  });
  //$('textarea').autosize(); //AUTO-RESIZE ALL TEXTAREA ELEMENTS
  /*
  if (OnEditor()) {
    $(window).bind('beforeunload', function(){
      return 'Are you sure you want to leave? Any changes NOT SAVED will be lost!';
    });
    $('#save').click(function(){
      window.alert("save");
    });
    $('#export').click(function(){
      window.alert("export");
    });
    $('#import').click(function(){
      window.alert("import");
    });
    $('#undo').click(function(){
      window.alert("undo");
    });
    $('#redo').click(function(){
      window.alert("redo");
    });
  }
  */
});

function SetRibbon() {
  var url = window.location.href.toString();
  if (url.includes("index")) {
    $("#index").addClass("active");
  } else if (url.includes("support")) {
    $("#support").addClass("active");
  } else if (url.includes("dashboard")) {
    $("#dashboard").addClass("active");
  } else if (url.includes("options")) {
    $("#options").addClass("active");
  }
}

function CreateBreadcrumbs() {

}

function OnEditor() {
  var url = window.location.href.toString();
  if (url.includes("editor")) {
    return true;
  } else {
    return false;
  }
}

function SearchByTag(value) {
  value = value.toLowerCase();
  $('#search-bar').val(value);
  $('#search-form').submit(); //THIS DOES NOT WORK
}

function GenerateBitcoinWallet() {
  alert("GenerateBitcoinWallet");
}

function GenerateEthereumWallet() {
  alert("GenerateEthereumWallet");
}

function ProfileImport() {
  //var file = window.location = "file:///" + file;
}

function ProfileExport() {

}

function ProjectImport() {

}

function ProjectExport() {

}

















/*
var history = null;
var hindex = 0; //HISTORY INDEX
var maxi = 0; //MAXIMUM INDEX

function addAction() {
  hindex++;
  maxi = hindex;
}

function readdAction() {
  hindex++;
  maxi = hindex;
}

function removeAction() {

}

function Undo() {
  if (hindex <= 0) { //STOP UNDO
    return;
  }
  hindex--; //DECREMENT
}

function Redo() {
  if (hindex >= maxi) { //STOP REDO
    return;
  }
  hindex++;
}

//// TODO:
/*
UNDO
REDO
FULL WIDTH BAR WITH ICONS SUCH AS SAVE
HIGHLIGHT TEXT
STOP TABS, ETC FROM FUNCTIONING IN EDIT MODE
EDIT TAB HEADERS
SHOW MORE FEATURES
*/

/*
//Anchor Preview
/*$('.breadcrumbs').addClass('no-ap'); //No HP
$('footer').addClass('no-ap'); //No HP
$('.no-ap').find('a').each(function(){ //No HP
  $(this).addClass('no-ap-a');
});
$('main a').not('.no-ap-a').mouseenter(function(){
  var con = $(this).text(),
      src = $(this).attr('href');
  $(this).append('<div class="preview"><img src="media/img/land.jpg" alt="' + con + '"></img><p>' + con + '</p></div>')
});
$('main a').mouseleave(function(){
  $('.preview').remove();
});*/
