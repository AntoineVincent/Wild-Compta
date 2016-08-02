$(document).ready(function() 
{
	var bouton;

	$('.but').click(function()
	{
		if ($(this).hasClass("but1")) 
		{
			bouton = 1;
		}
		else if ($(this).hasClass("but2")) 
		{
			bouton = 2;
		}
		else 
		{
			bouton = 3;
		}

		if ($('.case'+bouton).hasClass("open"))
		{
			$('.pageother').css("display","none");
			$('.case'+bouton).removeClass("open");
		}
		else
		{
			$('.pageother').css("display","none");
			$('.pageother').removeClass("open");
			$('.case'+bouton).css("display","block");
			$('.case'+bouton).addClass("open");
		}
	});
});