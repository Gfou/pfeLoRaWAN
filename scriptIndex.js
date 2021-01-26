		var listForm=[];
		var indiceOpen=0;

		function newLine(id){
			var ID=id+'C';
			var DIV=id+'D';
			if (!listForm.includes(id)){

				var line=document.getElementById(ID);
				var div=document.getElementById(DIV);

				listForm.forEach((form) => {	
					console.log(form);
					var remove=document.getElementById(form+'F');
					var removeDiv=document.getElementById(form+'D');
					const index = listForm.indexOf(form);
					listForm.splice(index,1);
					removeDiv.removeChild(remove);
				})

				var f = document.createElement("FORM");
				f.setAttribute('id',id+'F');
				f.setAttribute('method',"post");
				f.setAttribute('action',"gestionCapteurs/modification.php?id="+id);
				f.setAttribute('style',"position:relative; margin-left:15px; margin-top:1%;");

				var drow = document.createElement("div");
				drow.setAttribute('class',"row");
	
				var dcol1 = document.createElement("div");
				dcol1.setAttribute('class',"col");
	
				var dcol2 = document.createElement("div");
				dcol2.setAttribute('class',"col");

				var dcol3 = document.createElement("div");
				dcol3.setAttribute('class',"col");
			
				var dcol4 = document.createElement("div");
				dcol4.setAttribute('class',"col");
			
				var dcol5 = document.createElement("div");
				dcol5.setAttribute('class',"col");
	
				var c = document.createElement("input");
				c.setAttribute('type',"text");
				c.setAttribute('name',"coordonneesM");	
				c.setAttribute('placeholder',"Coordinates");
				c.setAttribute('class',"form-control");
			
				var p = document.createElement("input");
				p.setAttribute('type',"text");
				p.setAttribute('name',"paysM");	
				p.setAttribute('placeholder',"Country");
				p.setAttribute('class',"form-control");
			
				var v = document.createElement("input");
				v.setAttribute('type',"text");
				v.setAttribute('name',"villeM");	
				v.setAttribute('placeholder',"City");
				v.setAttribute('class',"form-control");
			
				var l = document.createElement("input");
				l.setAttribute('type',"text");
				l.setAttribute('name',"localisationM");	
				l.setAttribute('placeholder',"Location");
				l.setAttribute('class',"form-control");
			
				var b = document.createElement("button");
				b.setAttribute('type',"submit");
				b.setAttribute('class',"btn btn-primary");

				var s = document.createElement("span");
				s.setAttribute('style',"font-size:10px");

				var t = document.createTextNode("Confirm modification for "+id);
	
				s.appendChild(t);
				b.appendChild(s);
				dcol1.appendChild(c);
				dcol2.appendChild(p);
				dcol3.appendChild(v);
				dcol4.appendChild(l);
				dcol5.appendChild(b);
				drow.append(dcol1, dcol2, dcol3, dcol4, dcol5);
				f.appendChild(drow);
				div.appendChild(f);

				listForm.push(id);
			}
			else{
				
				var div=document.getElementById(DIV);
				var form=document.getElementById(id+'F');
				const index = listForm.indexOf(id);
				listForm.splice(index,1);
				div.removeChild(form);
				
			}
		}


		function deleteBalise(id){
			if(confirm("Delete balise with ID "+id+" ?")){
				console.log("toto");
				document.location.href='gestionCapteurs/suppression.php?id='+id;
			}
			else{}
		}


		function disable(id){
			document.location.href='gestionCapteurs/desactivation.php?id='+id;
		}


		function addSensor(){
				
			var div=document.getElementById('add');
			if (indiceOpen==0){	
				var f = document.createElement("FORM");
				f.setAttribute('id',"addForm");
				f.setAttribute('method',"post");
				f.setAttribute('action',"gestionCapteurs/ajout2.php");
				f.setAttribute('style',"position:relative; margin-left:15px; margin-top:1%;");

				var drow = document.createElement("div");
				drow.setAttribute('class',"row");
	
				var dcol1 = document.createElement("div");
				dcol1.setAttribute('class',"col");
	
				var dcol2 = document.createElement("div");
				dcol2.setAttribute('class',"col");

				var dcol3 = document.createElement("div");
				dcol3.setAttribute('class',"col");
			
				var dcol4 = document.createElement("div");
				dcol4.setAttribute('class',"col");
			
				var dcol5 = document.createElement("div");
				dcol5.setAttribute('class',"col");

				var dcol6 = document.createElement("div");
				dcol6.setAttribute('class',"col");

				var i = document.createElement("input");

				i.setAttribute('type',"text");
				i.setAttribute('name',"idA");	
				i.setAttribute('placeholder',"Id");
				i.setAttribute('class',"form-control");
				i.setAttribute('required',"required");
	
				var c = document.createElement("input");
				c.setAttribute('type',"text");
				c.setAttribute('name',"coordonneesA");	
				c.setAttribute('placeholder',"Coordinates");
				c.setAttribute('class',"form-control");	
				c.setAttribute('required',"required");
			
				var p = document.createElement("input");
				p.setAttribute('type',"text");
				p.setAttribute('name',"paysA");	
				p.setAttribute('placeholder',"Country");
				p.setAttribute('class',"form-control");
				p.setAttribute('required',"required");

				var v = document.createElement("input");
				v.setAttribute('type',"text");
				v.setAttribute('name',"villeA");	
				v.setAttribute('placeholder',"City");
				v.setAttribute('class',"form-control");
				v.setAttribute('required',"required");
				
				var l = document.createElement("input");
				l.setAttribute('type',"text");
				l.setAttribute('name',"localisationA");	
				l.setAttribute('placeholder',"Location");
				l.setAttribute('class',"form-control");
				l.setAttribute('required',"required");

				var b = document.createElement("button");
				b.setAttribute('type',"submit");
				b.setAttribute('class',"btn btn-primary");

				var s = document.createElement("span");
				s.setAttribute('style',"font-size:15px");

				var t = document.createTextNode("Confirm");
	
				s.appendChild(t);
				b.appendChild(s);
				dcol1.appendChild(i);
				dcol2.appendChild(p);
				dcol3.appendChild(v);
				dcol4.appendChild(l);
				dcol5.appendChild(c);
				dcol6.appendChild(b);
				drow.append(dcol1, dcol2, dcol3, dcol4, dcol5, dcol6);
				f.appendChild(drow);
				div.appendChild(f);
				indiceOpen=1;
			}
			else{
				var form=document.getElementById('addForm');
				div.removeChild(form);
				indiceOpen=0;
			}

		}


		function result(code){
			var div = document.getElementById('resultAdd');
			if (code==1){
				var p = document.createElement("p");
				p.setAttribute('style',"width:10%; margin-left:auto; margin-right:auto;");
				var text = document.createTextNode("Sensor added");
				p.appendChild(text);
			}
			else if(code==3){
				var p = document.createElement("p");
				p.setAttribute('style',"width:10%; margin-left:auto; margin-right:auto;");
				var text = document.createTextNode("ERROR : WRONG devEUI");
				p.appendChild(text);
			}
			else if(code==6){
				var p = document.createElement("p");
				p.setAttribute('style',"width:30%; margin-left:auto; margin-right:auto;");
				var text = document.createTextNode("ERROR : devEUI OR LOCALISATION ALREADY UTILISED");
				p.appendChild(text);
			}
			else{ 
				var p = document.createElement("p");
				p.setAttribute('style',"width:30%; margin-left:auto; margin-right:auto;");
				var text = document.createTextNode("ERROR : UNKNOW ERROR, TRY AGAIN LATER");
				p.appendChild(text);
			}

			div.appendChild(p);
		}

