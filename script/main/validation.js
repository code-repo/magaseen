function trim(str)
{
   return str.replace(/^\s*|\s*$/g,"");
}

function isEmail(aStr)
{
	var reEmail=/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/;
	if(!reEmail.test(aStr))
	{
		return false;
	}
	return true;
}

function formatCurrency(num) 
{
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
		num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
		cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+','+
	num.substring(num.length-(4*i+3));
	return (((sign)?'':'-') + '£' + num + '.' + cents);
}

function isUrl(s) 
{
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}
/*For star rating*/
function starRate(num)
{	
	var clas;
	clas = 'rating star'+num;
	document.getElementById('txtRate').value=num;
	document.getElementById('star').className=clas;
}

function starComment(comment)
{	
	document.getElementById('star_comment').innerHTML = comment;
}

function setStarComment()
{	
	var num = document.getElementById('txtRate').value;
	if(num == 1)
		document.getElementById('star_comment').innerHTML = 'Poor';
	else if(num == 2)
		document.getElementById('star_comment').innerHTML = 'Below Average';
	else if(num == 3)
		document.getElementById('star_comment').innerHTML = 'Average';
	else if(num == 4)
		document.getElementById('star_comment').innerHTML = 'Good';
	else if(num == 5)
		document.getElementById('star_comment').innerHTML = 'Excellent';
	else 
		document.getElementById('star_comment').innerHTML = '';
}

function imposeMaxLength(field, maxlen) 
{
	if (field.value.length > maxlen)
	{
		alert('Your cannot enter more then '+maxlen+' characters.');
		field.value = field.value.substring(0, maxlen-1);
		return false;
	}
}

function checkDomain(nname)
{
	var arr = new Array(
	'.com','.net','.org','.biz','.coop','.info','.museum','.name',
	'.pro','.edu','.gov','.int','.mil','.ac','.ad','.ae','.af','.ag',
	'.ai','.al','.am','.an','.ao','.aq','.ar','.as','.at','.au','.aw',
	'.az','.ba','.bb','.bd','.be','.bf','.bg','.bh','.bi','.bj','.bm',
	'.bn','.bo','.br','.bs','.bt','.bv','.bw','.by','.bz','.ca','.cc',
	'.cd','.cf','.cg','.ch','.ci','.ck','.cl','.cm','.cn','.co','.cr',
	'.cu','.cv','.cx','.cy','.cz','.de','.dj','.dk','.dm','.do','.dz',
	'.ec','.ee','.eg','.eh','.er','.es','.et','.fi','.fj','.fk','.fm',
	'.fo','.fr','.ga','.gd','.ge','.gf','.gg','.gh','.gi','.gl','.gm',
	'.gn','.gp','.gq','.gr','.gs','.gt','.gu','.gv','.gy','.hk','.hm',
	'.hn','.hr','.ht','.hu','.id','.ie','.il','.im','.in','.io','.iq',
	'.ir','.is','.it','.je','.jm','.jo','.jp','.ke','.kg','.kh','.ki',
	'.km','.kn','.kp','.kr','.kw','.ky','.kz','.la','.lb','.lc','.li',
	'.lk','.lr','.ls','.lt','.lu','.lv','.ly','.ma','.mc','.md','.mg',
	'.mh','.mk','.ml','.mm','.mn','.mo','.mp','.mq','.mr','.ms','.mt',
	'.mu','.mv','.mw','.mx','.my','.mz','.na','.nc','.ne','.nf','.ng',
	'.ni','.nl','.no','.np','.nr','.nu','.nz','.om','.pa','.pe','.pf',
	'.pg','.ph','.pk','.pl','.pm','.pn','.pr','.ps','.pt','.pw','.py',
	'.qa','.re','.ro','.rw','.ru','.sa','.sb','.sc','.sd','.se','.sg',
	'.sh','.si','.sj','.sk','.sl','.sm','.sn','.so','.sr','.st','.sv',
	'.sy','.sz','.tc','.td','.tf','.tg','.th','.tj','.tk','.tm','.tn',
	'.to','.tp','.tr','.tt','.tv','.tw','.tz','.ua','.ug','.uk','.um',
	'.us','.uy','.uz','.va','.vc','.ve','.vg','.vi','.vn','.vu','.ws',
	'.wf','.ye','.yt','.yu','.za','.zm','.zw');

	var mai = nname;
	var val = true;

	var dot = mai.lastIndexOf(".");
	var dname = mai.substring(0,dot);
	var ext = mai.substring(dot,mai.length);
	//alert(ext);
		
	if(dot>2 && dot<57)
	{
		for(var i=0; i<arr.length; i++)
		{
		  if(ext == arr[i])
		  {
			val = true;
			break;
		  }	
		  else
		  {
			val = false;
		  }
		}
		if(val == false)
		{
			 alert("Your url extension "+ext+" is not correct");
			 return false;
		}
		else
		{
			for(var j=0; j<dname.length; j++)
			{
			  var dh = dname.charAt(j);
			  var hh = dh.charCodeAt(0);
			  if((hh > 47 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123) || hh==45 || hh==46)
			  {
				 if((j==0 || j==dname.length-1) && hh == 45)	
				 {
					 alert("Website url name should not begin are end with '-'");
					  return false;
				 }
			  }
			else	{
				 alert("Your Website url name should not have special characters");
				 return false;
			  }
			}
		}
	}
	else
	{
	 alert("Incorrect Website url name");
	 return false;
	}	
	return true;
}
