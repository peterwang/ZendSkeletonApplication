(function(){

  $(document).ready(function(){
    $('a#togglephpinfo').click(function(event){
      var info = $('div#phpinfo');
      if (info.css('display') == 'none'){
		  info.show('fast');
	  } else {
		  info.hide('fast');
	  }
    });
  });

})();
