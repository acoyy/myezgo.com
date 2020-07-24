function selectNRIC(e){

	var t=new myAjax;
	t.method="GET",
	t.url="ajax.php?t=selectNRIC&nric="+e,
	t.success=function(){
		var e=t.myObject.GetResponse().split("|||");
		document.getElementById("firstname").value=e[0],
		document.getElementById("address").value=e[1],
		document.getElementById("postcode").value=e[2],
		document.getElementById("city").value=e[3],
		document.getElementById("country").value=e[4],
		document.getElementById("title").value=e[5],
		document.getElementById("lastname").value=e[6],
		document.getElementById("age").value=e[7],
		document.getElementById("phone_no").value=e[8],
		document.getElementById("email").value=e[9],
		document.getElementById("ref_name").value=e[10],
		document.getElementById("ref_phoneno").value=e[11],
		document.getElementById("license_no").value=e[12],
		document.getElementById("ref_relationship").value=e[13],
		document.getElementById("ref_address").value=e[14],
		document.getElementById("license_exp").value=e[15]
	},
	t.send()
}

function calcPrice(e,t,n,s){
	for(i=0;i<s;i++){
		if(1==document.getElementById("description["+i+"]").checked)(c=new myAjax).method="GET",
			c.url="ajax.php?t=calcPrice&check=true&price="+e+"&desc="+t+"&qty="+n;
		else if(0==document.getElementById("description[0]").checked){
			var c;
			(c=new myAjax).method="GET",
			c.url="ajax.php?t=calcPrice&check=false&price="+e+"&desc="+t+"&qty="+n
		}
		c.success=function(){
			var e=c.myObject.GetResponse().split("|||");
			document.getElementById("price").innerHTML=e[0],
			document.getElementById("gst").innerHTML=e[1],
			document.getElementById("estimate_total").innerHTML=e[2],
			document.getElementById("pricehidden").value=e[0],
			document.getElementById("gsthidden").value=e[1],
			document.getElementById("estimate_totalhidden").value=e[1]},
			c.send()
		}
	}

	function loadAjax2(e,t){
		var n=new myAjax;
		n.method="GET",
		n.url=e,
		n.success=function(){
			var e=n.myObject.GetResponse();
			$(t)&&($(t).value=e)
		},
		n.send()
	}

	function myAjax(e){
		var t="";
		this.send=function(){
			t=this.param?this.url+"?"+this.param:this.url,
			this.myObject=new ajax,
			this.myObject.InitializeRequest(this.method?this.method:"GET",t,this.asyn),
			this.success&&(this.myObject.OnSuccess=this.success),
			this.uninitialize&&(this.myObject.OnUninitialize=this.uninitialize),
			this.loading&&(this.myObject.OnLoading=this.loading),
			this.loaded&&(this.myObject.OnLoaded=this.loaded),
			this.interactive&&(this.myObject.OnInteractive=this.interactive),
			this.failure&&(this.myObject.OnFailure=this.failure),
			this.data?this.myObject.Commit(this.data):this.myObject.Commit("")
		}
	}

	function ajax(){
		var i=null,s=null;
		function c(){
			switch(i.readyState){
				case 0:window.setTimeout("void(0)",100),
				s.OnUninitialize();
				break;
				case 1:window.setTimeout("void(0)",100),
				s.OnLoading();
				break;
				case 2:window.setTimeout("void(0)",100),
				s.OnLoaded();
				break;
				case 3:window.setTimeout("void(0)",100),
				s.OnInteractive();
				break;
				case 4:return void(200==i.status?s.OnSuccess():s.OnFailure())
			}
		}
		this.GetResponseXML=function(){ return i?i.responseXML:null },
		this.GetResponse=function(){
			if(i){
				var e=0<=i.getResponseHeader("content-type").indexOf("xml");
				return data=e?i.responseXML:i.responseText,data
			}	
			return null
		},
		this.GetRequestObject=function(){return i},
		this.InitializeRequest=function(e,t,n){
			switch((i=function(){
				var t;
				try{
					t=new XMLHttpRequest
				}catch(e){
					try{
						t=new ActiveXObject("Microsoft.XMLHTTP")
					}catch(e){
						return null
					}
				}
				return t
			}()).onreadystatechange=c,
			s=this,
			arguments.length){
				case 2:i.open(e,t);
				break;
				case 3:i.open(e,t,n)
			}
			4<=arguments.length&&i.open(e,t,n,arguments[3]),
			this.SetRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8")
		},
		this.SetRequestHeader=function(e,t){
			i&&i.setRequestHeader(e,t)
		},
		this.Commit=function(e){
			i&&(i.send(e),c())
		},
		this.Close=function(){
			i&&i.abort()
		},
		this.OnUninitialize=function(){},
		this.OnLoading=function(){},
		this.OnLoaded=function(){},
		this.OnInteractive=function(){},
		this.OnSuccess=function(){},
		this.OnFailure=function(){}}