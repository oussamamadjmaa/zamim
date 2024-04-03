import{_ as H,M as j,a as J,b as K,c as $,d as te,e as oe,f as se}from"./NotificationsComponent-d6fe5fd3.js";import{B,H as Z,I as z,r as G,k as d,C as h,i as k,J as t,g as L,v as O,x as F,F as V,j as r,m as e,t as n,q,l as M,K as I,e as X,y as ne,L as le,E as ae,G as Y}from"./common-7c3a6321.js";function W(){const{callApi:D,fetchAll:l,fetchOne:i,makeFetchAllRef:x,makeFormRef:b,storeForm:g}=B(),o=`${window._app.url}/students`,_=x(),c=async(w=null)=>{await l(w??o,_)},T=async w=>await i(`${o}/${w}`),C=b({profile:{}},o),P=async()=>{await g(C,_)},S=b({},o+"/import");return{students:_,getStudents:c,getStudent:T,studentForm:C,storeStudent:P,destroyStudent:w=>{_.value.list=_.value.list.filter(A=>A!=w),D({url:o+"/"+w.id,method:"POST",data:{_method:"DELETE"}})},importStudentForm:S,importStudents:async()=>{await g(S,_,{headers:{"Content-Type":"multipart/form-data"},successCallback:()=>setTimeout(()=>{window.location.reload()},2e3)})},pageUrl:o}}const ie={class:"d-flex flex-wrap justify-content-between mb-4"},re=["textContent"],de=["placeholder"],ue={class:"text-end"},ce=e("ion-icon",{name:"cloud-upload-outline"},null,-1),pe=e("ion-icon",{name:"add"},null,-1),me={key:0,class:"text-center"},_e=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),he=[_e],ve=["textContent"],fe={key:2,class:"text-center"},be=e("th",null,"#",-1),ye=["textContent"],$e=["textContent"],xe=["href","textContent"],Ce=["textContent"],we=["href","textContent"],ge=["href","textContent"],ke=["textContent"],Ve=["textContent"],Se=["textContent"],Te={class:"d-flex"},Ue=["onClick"],Ae=e("ion-icon",{name:"create-outline"},null,-1),De=[Ae],Pe=["onClick"],Fe=e("ion-icon",{name:"trash-outline"},null,-1),Ee=[Fe],Re={key:4,class:"is-proccessing"},qe=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),Me=[qe],Ne={class:"p-5 px-4"},Le=["textContent"],Oe={class:"row"},je=["textContent"],Ie={class:"row"},Be={class:"mt-3"},Ge=["disabled"],He={class:"p-5 px-4"},Ke={class:"mb-3 col-12"},Ze={class:"mb-3"},ze=["textContent"],Je=["placeholder"],We={class:"mt-3"},Qe=["disabled"],Xe={__name:"StudentsComponent",setup(D){const l=Z("trans"),{students:i,getStudents:x,getStudent:b,storeStudent:g,studentForm:o,destroyStudent:_,importStudentForm:c,importStudents:T}=W(),C=async()=>{await g(),o.value.response.status==200&&!o.value.update&&(o.value.show=!1)},P=async m=>{i.value.isProccessing=!0,m=await b(m.id),i.value.isProccessing=!1,m&&(i.value.list=i.value.list.map(a=>a.id==m.id?m:a),o.value.show=!0,o.value.data={name:m.name,email:m.email,phone_number:m.phoneNumber,profile:{parent_name:m.profile.parentName,parent_email:m.profile.parentEmail,level:m.profile.level,class:m.profile.class,division:m.profile.division}},o.value.update=m)},S=()=>{o.value.show=!1,o.value.errors=[]},y=()=>{c.value.show=!1,c.value.errors=[]},U=m=>{c.value.data.file=m.target.files.length>0?m.target.files[0]:null};z(()=>{o.value.show||(o.value.response=null,o.value.errors=[],o.value.update&&(o.value.data=o.value.defaultData,o.value.update=null)),c.value.show||(c.value.response=null,c.value.errors=[])});const w=m=>{confirm(l("Do you really want to delete this record?"))&&_(m)};x();const A=G(null),R=m=>{A.value&&clearTimeout(A.value),i.value.search=m.target.value,A.value=setTimeout(()=>{x()},600)};return(m,a)=>(r(),d(V,null,[h(H,null,{header:k(()=>[e("div",ie,[e("h6",{class:"h7",textContent:n(t(l)("Students"))},null,8,re),e("input",{type:"text",class:"form-control mb-2",style:{"max-width":"300px"},placeholder:t(l)("Search"),onKeyup:a[0]||(a[0]=s=>R(s))},null,40,de),e("div",ue,[e("button",{class:"button bg-primary mb-2 me-2",onClick:a[1]||(a[1]=s=>t(c).show=!t(c).show)},[ce,q(" "+n(t(l)("Import students")),1)]),e("button",{class:"primary-button mb-2",onClick:a[2]||(a[2]=s=>t(o).show=!t(o).show)},[pe,q(" "+n(t(l)("Add new student")),1)])])])]),default:k(()=>[e("div",null,[t(i).response?t(i).response.status!=200?(r(),d("div",{key:1,class:"text-center text-danger",textContent:n(t(i).response.data.message||t(i).response.statusText)},null,8,ve)):t(i).list.length==0?(r(),d("div",fe,n(t(l)("No Data")),1)):(r(),d(V,{key:3},[h(J,null,{thead:k(()=>[e("tr",null,[be,e("th",null,n(t(l)("Student name")),1),e("th",null,n(t(l)("Official email")),1),e("th",null,n(t(l)("Guardian name")),1),e("th",null,n(t(l)("Guardian phone number")),1),e("th",null,n(t(l)("Guardian email")),1),e("th",null,n(t(l)("Level")),1),e("th",null,n(t(l)("Class")),1),e("th",null,n(t(l)("Division")),1),e("th",null,n(t(l)("Operations")),1)])]),default:k(()=>[(r(!0),d(V,null,M(t(i).list,s=>(r(),d("tr",{key:s.id},[e("td",{scope:"row",textContent:n(s.id)},null,8,ye),e("td",{textContent:n(s.name)},null,8,$e),e("td",null,[e("a",{href:"mailto:"+s.email,textContent:n(s.email)},null,8,xe)]),e("td",{textContent:n(s.profile.parentName)},null,8,Ce),e("td",null,[s.phoneNumber?(r(),d("a",{key:0,href:"tel:"+s.phoneNumber,textContent:n(s.phoneNumber),dir:"ltr"},null,8,we)):(r(),d(V,{key:1},[q(n(t(l)("Not included")),1)],64))]),e("td",null,[s.profile.parentEmail?(r(),d("a",{key:0,href:"mailto:"+s.profile.parentEmail,textContent:n(s.profile.parentEmail),dir:"ltr"},null,8,ge)):(r(),d(V,{key:1},[q(n(t(l)("Not included")),1)],64))]),e("td",{textContent:n(s.profile.levelText)},null,8,ke),e("td",{textContent:n(s.profile.class)},null,8,Ve),e("td",{textContent:n(s.profile.division)},null,8,Se),e("td",Te,[e("button",{type:"button",class:"primary-button p-0 px-2 me-2",onClick:v=>P(s)},De,8,Ue),e("button",{type:"button",onClick:v=>w(s),class:"button button-red p-0 px-2"},Ee,8,Pe)])]))),128))]),_:1}),h(K,{meta:t(i).response.data.meta,onUpdateList:t(x)},null,8,["meta","onUpdateList"])],64)):(r(),d("div",me,he)),t(i).isProccessing&&t(i).response?(r(),d("div",Re,Me)):F("",!0)])]),_:1}),t(o).show?(r(),L(j,{key:0,onCloseModal:a[13]||(a[13]=s=>S()),class:O({"w-1000px":!0})},{default:k(()=>[e("div",Ne,[e("form",{onSubmit:a[12]||(a[12]=I(s=>C(),["prevent"]))},[e("h6",{class:"h9 border-bottom pb-3 mb-4",textContent:n(t(l)("Student information"))},null,8,Le),e("div",Oe,[h($,{class:"col-md-6",errors:t(o).errors.name,label:'<ion-icon name="person"></ion-icon>',placeholder:"Student name",modelValue:t(o).data.name,"onUpdate:modelValue":a[3]||(a[3]=s=>t(o).data.name=s),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-6",type:"email",errors:t(o).errors.email,label:'<ion-icon name="mail"></ion-icon>',placeholder:"Official email",modelValue:t(o).data.email,"onUpdate:modelValue":a[4]||(a[4]=s=>t(o).data.email=s),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-6",type:"select",searchable:!0,label:'<ion-icon name="school"></ion-icon>',placeholder:"Level",errors:t(o).errors["profile.level"],modelValue:t(o).data.profile.level,"onUpdate:modelValue":a[5]||(a[5]=s=>t(o).data.profile.level=s),options:{primary:t(l)("Primary"),middle:t(l)("Middle"),secondary:t(l)("Secondary")},required:!0},null,8,["errors","modelValue","options"]),h($,{class:"col-md-6",errors:t(o).errors["profile.class"],label:'<ion-icon name="bookmark"></ion-icon>',placeholder:"Class",modelValue:t(o).data.profile.class,"onUpdate:modelValue":a[6]||(a[6]=s=>t(o).data.profile.class=s),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-6",errors:t(o).errors["profile.division"],label:'<ion-icon name="bookmark"></ion-icon>',placeholder:"Division",modelValue:t(o).data.profile.division,"onUpdate:modelValue":a[7]||(a[7]=s=>t(o).data.profile.division=s),required:!0},null,8,["errors","modelValue"])]),e("h6",{class:"h9 border-bottom pb-3 mb-4",textContent:n(t(l)("Guardian information"))},null,8,je),e("div",Ie,[h($,{class:"col-md-6",errors:t(o).errors["profile.parent_name"],label:'<ion-icon name="person"></ion-icon>',placeholder:"Name",modelValue:t(o).data.profile.parent_name,"onUpdate:modelValue":a[8]||(a[8]=s=>t(o).data.profile.parent_name=s),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-6",errors:t(o).errors.phone_number,label:'<ion-icon name="call"></ion-icon>',dir:"ltr",placeholder:"Guardian phone",modelValue:t(o).data.phone_number,"onUpdate:modelValue":a[9]||(a[9]=s=>t(o).data.phone_number=s),required:!0},null,8,["errors","modelValue"]),h($,{type:"email",class:"col-md-6",errors:t(o).errors["profile.parent_email"],label:'<ion-icon name="mail"></ion-icon>',placeholder:"Guardian email",modelValue:t(o).data.profile.parent_email,"onUpdate:modelValue":a[10]||(a[10]=s=>t(o).data.profile.parent_email=s)},null,8,["errors","modelValue"])]),e("div",Be,[e("button",{type:"submit",class:"primary-button",disabled:t(o).processing},n(t(o).processing?t(l)("Please wait"):t(o).update?t(l)("Update"):t(l)("Save")),9,Ge),e("button",{type:"button",class:"secondary-button ms-2",onClick:a[11]||(a[11]=s=>S())},n(t(l)("Close")),1)])],32)])]),_:1})):F("",!0),t(c).show?(r(),L(j,{key:1,onCloseModal:a[18]||(a[18]=s=>y()),class:O({"w-1000px":!0})},{default:k(()=>[e("div",He,[e("form",{onSubmit:a[17]||(a[17]=I(s=>t(T)(),["prevent"]))},[h($,{type:"select",searchable:!0,label:'<ion-icon name="school"></ion-icon>',placeholder:"Level",errors:t(c).errors.level,modelValue:t(c).data.level,"onUpdate:modelValue":a[14]||(a[14]=s=>t(c).data.level=s),options:{primary:t(l)("Primary"),middle:t(l)("Middle"),secondary:t(l)("Secondary")},required:!0},null,8,["errors","modelValue","options"]),e("div",Ke,[e("div",Ze,[e("label",{for:"file",class:"form-label",textContent:n(t(l)("Excel file"))},null,8,ze),e("input",{type:"file",class:"form-control",onChange:a[15]||(a[15]=s=>U(s)),id:"file",placeholder:t(l)("Excel file"),accept:".xlsx, .xls",required:""},null,40,Je)])]),e("div",We,[e("button",{type:"submit",class:"primary-button",disabled:t(c).processing},n(t(c).processing?t(l)("Please wait")+" ("+t(c).process.percent+"%)":t(l)("Import")),9,Qe),e("button",{type:"button",class:"secondary-button ms-2",onClick:a[16]||(a[16]=s=>y())},n(t(l)("Close")),1)])],32)])]),_:1})):F("",!0)],64))}};function Q(){const{callApi:D,fetchAll:l,fetchOne:i,makeFetchAllRef:x,makeFormRef:b,storeForm:g}=B(),o=`${window._app.url}/teachers`,_=x(),c=async(w=null)=>{await l(w??o,_)},T=async w=>await i(`${o}/${w}`),C=b({},o),P=async()=>{await g(C,_)},S=b({},o+"/import");return{teachers:_,getTeachers:c,getTeacher:T,teacherForm:C,storeTeacher:P,destroyTeacher:w=>{_.value.list=_.value.list.filter(A=>A!=w),D({url:o+"/"+w.id,method:"POST",data:{_method:"DELETE"}})},importTeacherForm:S,importTeachers:async()=>{await g(S,_,{headers:{"Content-Type":"multipart/form-data"},successCallback:()=>setTimeout(()=>{window.location.reload()},2e3)})},pageUrl:o}}const Ye={class:"d-flex flex-wrap justify-content-between mb-4"},et=["textContent"],tt=["placeholder"],ot={class:"text-end"},st=e("ion-icon",{name:"cloud-upload-outline"},null,-1),nt={key:0,class:"text-center"},lt=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),at=[lt],it=["textContent"],rt={key:2,class:"text-center"},dt=e("th",null,"#",-1),ut=["textContent"],ct=["textContent"],pt=["href","textContent"],mt=["href","textContent"],_t={class:"d-flex"},ht=["onClick"],vt=e("ion-icon",{name:"create-outline"},null,-1),ft=[vt],bt=["onClick"],yt=e("ion-icon",{name:"trash-outline"},null,-1),$t=[yt],xt={key:4,class:"is-proccessing"},Ct=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),wt=[Ct],gt={class:"p-5 px-4"},kt=["textContent"],Vt={class:"row"},St={class:"mt-3"},Tt=["disabled"],Ut={class:"p-5 px-4"},At={class:"mb-3 col-12"},Dt={class:"mb-3"},Pt=["textContent"],Ft=["placeholder"],Et={class:"mt-3"},Rt=["disabled"],qt={__name:"TeachersComponent",setup(D){const l=Z("trans"),{teachers:i,getTeachers:x,getTeacher:b,storeTeacher:g,teacherForm:o,destroyTeacher:_,importTeacherForm:c,importTeachers:T}=Q(),C=async()=>{await g(),o.value.response.status==200&&!o.value.update&&(o.value.show=!1)},P=async m=>{i.value.isProccessing=!0,m=await b(m.id),i.value.isProccessing=!1,m&&(i.value.list=i.value.list.map(a=>a.id==m.id?m:a),o.value.show=!0,o.value.data={name:m.name,email:m.email,phone_number:m.phoneNumber},o.value.update=m)},S=()=>{o.value.show=!1,o.value.errors=[]},y=()=>{c.value.show=!1,c.value.errors=[]},U=m=>{c.value.data.file=m.target.files.length>0?m.target.files[0]:null};z(()=>{o.value.show||(o.value.response=null,o.value.errors=[],o.value.update&&(o.value.data=o.value.defaultData,o.value.update=null))});const w=m=>{confirm(l("Do you really want to delete this record?"))&&_(m)};x();const A=G(null),R=m=>{A.value&&clearTimeout(A.value),i.value.search=m.target.value,A.value=setTimeout(()=>{x()},600)};return(m,a)=>(r(),d(V,null,[h(H,null,{header:k(()=>[e("div",Ye,[e("h6",{class:"h7",textContent:n(t(l)("Teachers"))},null,8,et),e("input",{type:"text",class:"form-control mb-2",style:{"max-width":"300px"},placeholder:t(l)("Search"),onKeyup:a[0]||(a[0]=s=>R(s))},null,40,tt),e("div",ot,[e("button",{class:"button bg-primary mb-2 me-2",onClick:a[1]||(a[1]=s=>t(c).show=!t(c).show)},[st,q(" "+n(t(l)("Import teachers")),1)]),e("button",{class:"primary-button",onClick:a[2]||(a[2]=s=>t(o).show=!t(o).show)},n(t(l)("Add new teacher")),1)])])]),default:k(()=>[e("div",null,[t(i).response?t(i).response.status!=200?(r(),d("div",{key:1,class:"text-center text-danger",textContent:n(t(i).response.data.message||t(i).response.statusText)},null,8,it)):t(i).list.length==0?(r(),d("div",rt,n(t(l)("No Data")),1)):(r(),d(V,{key:3},[h(J,null,{thead:k(()=>[e("tr",null,[dt,e("th",null,n(t(l)("Teacher name")),1),e("th",null,n(t(l)("Official email")),1),e("th",null,n(t(l)("Phone number")),1),e("th",null,n(t(l)("Operations")),1)])]),default:k(()=>[(r(!0),d(V,null,M(t(i).list,s=>(r(),d("tr",{key:s.id},[e("td",{scope:"row",textContent:n(s.id)},null,8,ut),e("td",{textContent:n(s.name)},null,8,ct),e("td",null,[e("a",{href:"mailto:"+s.email,textContent:n(s.email)},null,8,pt)]),e("td",null,[s.phoneNumber?(r(),d("a",{key:0,href:"tel:"+s.phoneNumber,textContent:n(s.phoneNumber),dir:"ltr"},null,8,mt)):(r(),d(V,{key:1},[q(n(t(l)("Not included")),1)],64))]),e("td",_t,[e("button",{type:"button",class:"primary-button p-0 px-2 me-2",onClick:v=>P(s)},ft,8,ht),e("button",{type:"button",onClick:v=>w(s),class:"button button-red p-0 px-2"},$t,8,bt)])]))),128))]),_:1}),h(K,{meta:t(i).response.data.meta,onUpdateList:t(x)},null,8,["meta","onUpdateList"])],64)):(r(),d("div",nt,at)),t(i).isProccessing&&t(i).response?(r(),d("div",xt,wt)):F("",!0)])]),_:1}),t(o).show?(r(),L(j,{key:0,onCloseModal:a[8]||(a[8]=s=>S()),class:O({"w-1000px":!0})},{default:k(()=>[e("div",gt,[e("form",{onSubmit:a[7]||(a[7]=I(s=>C(),["prevent"]))},[e("h6",{class:"h9 border-bottom pb-3 mb-4",textContent:n(t(l)("Teacher information"))},null,8,kt),e("div",Vt,[h($,{class:"col-md-6",errors:t(o).errors.name,label:'<ion-icon name="person"></ion-icon>',placeholder:"Teacher name",modelValue:t(o).data.name,"onUpdate:modelValue":a[3]||(a[3]=s=>t(o).data.name=s),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-6",type:"email",errors:t(o).errors.email,label:'<ion-icon name="mail"></ion-icon>',placeholder:"Official email",modelValue:t(o).data.email,"onUpdate:modelValue":a[4]||(a[4]=s=>t(o).data.email=s),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-6",errors:t(o).errors.phone_number,label:'<ion-icon name="call"></ion-icon>',placeholder:"Phone number",modelValue:t(o).data.phone_number,"onUpdate:modelValue":a[5]||(a[5]=s=>t(o).data.phone_number=s),dir:"ltr",required:!0},null,8,["errors","modelValue"])]),e("div",St,[e("button",{type:"submit",class:"primary-button",disabled:t(o).processing},n(t(o).processing?t(l)("Please wait"):t(o).update?t(l)("Update"):t(l)("Save")),9,Tt),e("button",{type:"button",class:"secondary-button ms-2",onClick:a[6]||(a[6]=s=>S())},n(t(l)("Close")),1)])],32)])]),_:1})):F("",!0),t(c).show?(r(),L(j,{key:1,onCloseModal:a[12]||(a[12]=s=>y()),class:O({"w-1000px":!0})},{default:k(()=>[e("div",Ut,[e("form",{onSubmit:a[11]||(a[11]=I(s=>t(T)(),["prevent"]))},[e("div",At,[e("div",Dt,[e("label",{for:"file",class:"form-label",textContent:n(t(l)("Excel file"))},null,8,Pt),e("input",{type:"file",class:"form-control",onChange:a[9]||(a[9]=s=>U(s)),id:"file",placeholder:t(l)("Excel file"),accept:".xlsx, .xls",required:""},null,40,Ft)])]),e("div",Et,[e("button",{type:"submit",class:"primary-button",disabled:t(c).processing},n(t(c).processing?t(l)("Please wait")+" ("+t(c).process.percent+"%)":t(l)("Import")),9,Rt),e("button",{type:"button",class:"secondary-button ms-2",onClick:a[10]||(a[10]=s=>y())},n(t(l)("Close")),1)])],32)])]),_:1})):F("",!0)],64))}};function Mt(){const{callApi:D,fetchAll:l,fetchOne:i,makeFetchAllRef:x,makeFormRef:b,storeForm:g}=B(),o=`${window._app.url}/radios`,_=x(),c=async(y=null)=>{await l(y??o,_)},T=async y=>await i(`${o}/${y}`),C=b({students:[]},o);return{radios:_,getRadios:c,getRadio:T,radioForm:C,storeRadio:async()=>{await g(C,_)},destroyRadio:y=>{_.value.list=_.value.list.filter(U=>U!=y),D({url:o+"/"+y.id,method:"POST",data:{_method:"DELETE"}})},pageUrl:o}}const Nt={class:"d-flex flex-wrap justify-content-between"},Lt={class:"h7 mb-2"},Ot=e("ion-icon",{name:"radio-outline"},null,-1),jt=["textContent"],It={class:"text-end"},Bt=e("ion-icon",{name:"add"},null,-1),Gt=e("p",{class:"p5 mb-5"},"لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل .",-1),Ht={key:0,class:"text-center"},Kt=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),Zt=[Kt],zt=["textContent"],Jt={key:2,class:"text-center"},Wt={key:3,class:"row px-0 mx-0"},Qt={class:"mx-3"},Xt={class:"table weekly-radios-table"},Yt=["textContent"],eo=["textContent"],to=["textContent"],oo=["textContent"],so=["textContent"],no=["onClick"],lo=e("ion-icon",{name:"eye-outline"},null,-1),ao=[lo],io=["onClick"],ro=e("ion-icon",{name:"create-outline"},null,-1),uo=[ro],co=["onClick"],po=e("ion-icon",{name:"trash-outline"},null,-1),mo=[po],_o={key:4,class:"is-proccessing"},ho=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),vo=[ho],fo={class:"p-5 px-4"},bo={class:"row"},yo={class:"d-flex flex-wrap list-unstyled"},$o=["onClick"],xo=["textContent"],Co={class:"mt-3"},wo=["disabled"],go={__name:"RadiosComponent",setup(D){const l=Z("trans"),{radios:i,getRadios:x,getRadio:b,storeRadio:g,radioForm:o,destroyRadio:_}=Mt(),{students:c,getStudents:T}=W(),{teachers:C,getTeachers:P}=Q(),S=async()=>{await g(),o.value.response.status==200&&!o.value.update&&(o.value.show=!1)},y=async s=>{if(i.value.isProccessing=!0,s=await b(s.id),i.value.isProccessing=!1,!s)return;i.value.list=i.value.list.map(u=>u.id==s.id?s:u),o.value.show=!0;const v=s.students.map(u=>u.id);o.value.data={name:s.name,class:s.class,radio_date:s.radioDate,teacher_id:s.teacher.id,students:v},o.value.update=s},U=()=>{o.value.show=!1,o.value.errors=[]},w=s=>{let v=i.value.list.filter(u=>u.weekNumber===parseInt(s));return i.value.response.data.weeks[`week-${s}`].show=v.length,v.sort((u,f)=>new Date(u.radioDate)-new Date(f.radioDate))};z(()=>{o.value.show||(o.value.response=null,o.value.errors=[],o.value.update&&(o.value.data=o.value.defaultData,o.value.update=null))});const A=X(()=>{const s={...c.value.list};return Object.keys(s).forEach(v=>{o.value.data.students.includes(parseInt(v))&&delete s[v]}),s}),R=s=>{confirm(l("Do you really want to delete this record?"))&&_(s)};x();const m=s=>{o.value.data.students=[...o.value.data.students,parseInt(s)]},a=s=>{confirm(l("Do you really want to delete this record?"))&&(o.value.data.students=o.value.data.students.filter(v=>v!=s))};return c.value.data_type="select",T(),C.value.data_type="select",P(),(s,v)=>(r(),d(V,null,[h(H,null,{default:k(()=>[e("div",Nt,[e("h6",Lt,[Ot,q(),e("span",{textContent:n(t(l)("School Radio"))},null,8,jt)]),e("div",It,[e("button",{class:"primary-button mb-2",onClick:v[0]||(v[0]=u=>t(o).show=!t(o).show)},[Bt,q(" "+n(t(l)("Create your school radio")),1)])])]),Gt,t(i).response?t(i).response.status!=200?(r(),d("div",{key:1,class:"text-center text-danger",textContent:n(t(i).response.data.message||t(i).response.statusText)},null,8,zt)):t(i).list.length==0?(r(),d("div",Jt,n(t(l)("No Data")),1)):(r(),d("div",Wt,[(r(!0),d(V,null,M(t(i).response.data.weeks,(u,f)=>ne((r(),d("div",{class:"col-md-6",key:f},[e("div",Qt,[e("table",Xt,[e("thead",null,[e("tr",null,[e("th",{colspan:"5",textContent:n(u.title+" ("+u.weekRangeHijri+")")},null,8,Yt)])]),e("tbody",null,[(r(!0),d(V,null,M(w(u.weekNumber),p=>(r(),d("tr",null,[e("td",{scope:"row",textContent:n(p.radioDay)},null,8,eo),e("td",{textContent:n(p.radioDateHijri)},null,8,to),e("td",{textContent:n(p.class)},null,8,oo),e("td",{textContent:n(p.teacher.name)},null,8,so),e("td",null,[e("button",{type:"button",class:"button secondary-button py-1 px-2 me-2",onClick:N=>y(p)},ao,8,no),e("button",{type:"button",class:"primary-button me-2 py-1 px-2",onClick:N=>y(p)},uo,8,io),e("button",{type:"button",onClick:N=>R(p),class:"button button-red py-1 px-2"},mo,8,co)])]))),256))])])])])),[[le,u.show]])),128))])):(r(),d("div",Ht,Zt)),t(i).isProccessing&&t(i).response?(r(),d("div",_o,vo)):F("",!0)]),_:1}),t(o).show?(r(),L(j,{key:0,onCloseModal:v[6]||(v[6]=u=>U()),class:O({"w-800px":!0})},{default:k(()=>[e("div",fo,[e("form",{onSubmit:v[5]||(v[5]=I(u=>S(),["prevent"]))},[e("div",bo,[h($,{class:"col-md-6",type:"date",errors:t(o).errors.radio_date,label:'<ion-icon name="calendar"></ion-icon>',placeholder:"Radio date",modelValue:t(o).data.radio_date,"onUpdate:modelValue":v[1]||(v[1]=u=>t(o).data.radio_date=u),minDate:s._app.currentSemester.startDate||null,maxDate:s._app.currentSemester.endDate||null,required:!0},null,8,["errors","modelValue","minDate","maxDate"]),h($,{class:"col-md-6",errors:t(o).errors.class,label:'<ion-icon name="bookmark"></ion-icon>',placeholder:"Class",modelValue:t(o).data.class,"onUpdate:modelValue":v[2]||(v[2]=u=>t(o).data.class=u),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-12",type:"select",searchable:!0,label:'<ion-icon name="person"></ion-icon>',placeholder:"Class leader",errors:t(o).errors.teacher_id,modelValue:t(o).data.teacher_id,"onUpdate:modelValue":v[3]||(v[3]=u=>t(o).data.teacher_id=u),options:t(C).list,required:!0},null,8,["errors","modelValue","options"]),h($,{class:"col-md-12",type:"select",isModel:!1,searchable:!0,label:'<ion-icon name="school"></ion-icon>',placeholder:"Participating students",errors:t(o).errors.students,onOnChange:m,options:A.value,required:!0},null,8,["errors","options"]),e("ul",yo,[(r(!0),d(V,null,M(t(o).data.students,u=>(r(),d("li",{onClick:f=>a(u),class:"bg-light p-2 me-2 mb-2 rounded-16"},[e("span",{textContent:n(t(c).list[u]||t(l)("Unknown"))},null,8,xo)],8,$o))),256))])]),e("div",Co,[e("button",{type:"submit",class:"primary-button",disabled:t(o).processing},n(t(o).processing?t(l)("Please wait"):t(o).update?t(l)("Update"):t(l)("Save")),9,wo),e("button",{type:"button",class:"secondary-button ms-2",onClick:v[4]||(v[4]=u=>U())},n(t(l)("Close")),1)])],32)])]),_:1})):F("",!0)],64))}};function ko(){const{callApi:D,fetchAll:l,fetchOne:i,makeFetchAllRef:x,makeFormRef:b,storeForm:g}=B(),o=`${window._app.url}/activities`,_=x(),c=async(y=null)=>{await l(y??o,_)},T=async y=>await i(`${o}/${y}`),C=b({students:{}},o);return{activities:_,getActivities:c,getActivity:T,activityForm:C,storeActivity:async()=>{await g(C,_)},destroyActivity:y=>{_.value.list=_.value.list.filter(U=>U!=y),D({url:o+"/"+y.id,method:"POST",data:{_method:"DELETE"}})},pageUrl:o}}const Vo={class:"bg-white border rounded-16 p-4"},So={class:"d-flex flex-wrap justify-content-between"},To=["textContent"],Uo=["placeholder"],Ao={class:"text-end"},Do={key:0,class:"text-center"},Po=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),Fo=[Po],Eo=["textContent"],Ro={key:2,class:"text-center"},qo={class:"activity-box"},Mo={class:"bg-image me-2"},No={class:"bg-image-holder"},Lo=["src","alt"],Oo={class:"activity-info"},jo={class:"h9 activity-title mb-1 me-2 d-inline"},Io=["textContent"],Bo=["textContent"],Go=e("ion-icon",{name:"people-outline",class:"me-2"},null,-1),Ho={class:"d-flex flex-wrap",style:{gap:"0.7rem"}},Ko=e("ion-icon",{name:"person-outline",class:"me-2"},null,-1),Zo=["textContent"],zo=e("ion-icon",{name:"bookmark-outline",class:"me-2"},null,-1),Jo=["textContent"],Wo={class:"actions mt-3"},Qo=["onClick"],Xo=["onClick"],Yo=e("ion-icon",{name:"create-outline"},null,-1),es=[Yo],ts=["onClick"],os=e("ion-icon",{name:"trash-outline"},null,-1),ss=[os],ns={key:4,class:"is-proccessing"},ls=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),as=[ls],is={class:"p-5 px-4"},rs={class:"row"},ds={class:"mb-3 col-12"},us={class:"image_"},cs={class:"image_-holder"},ps={key:0,class:"img_replacer"},ms={class:"iconsax","icon-name":"picture-no-square"},_s={width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",style:{width:"54px",height:"54px"},xmlns:"http://www.w3.org/2000/svg"},hs=e("path",{d:"M21.6799 16.9599L18.5499 9.64988C17.4899 7.16988 15.5399 7.06988 14.2299 9.42988L12.3399 12.8399C11.3799 14.5699 9.58993 14.7199 8.34993 13.1699L8.12993 12.8899C6.83993 11.2699 5.01993 11.4699 4.08993 13.3199L2.36993 16.7699C1.15993 19.1699 2.90993 21.9999 5.58993 21.9999H18.3499C20.9499 21.9999 22.6999 19.3499 21.6799 16.9599Z",stroke:"#292D32","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",fill:"#667080",style:{fill:"#667080",stroke:"#667080"}},null,-1),vs=e("path",{d:"M6.96997 8C8.62682 8 9.96997 6.65685 9.96997 5C9.96997 3.34315 8.62682 2 6.96997 2C5.31312 2 3.96997 3.34315 3.96997 5C3.96997 6.65685 5.31312 8 6.96997 8Z",stroke:"#292D32","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",style:{fill:"#667080",stroke:"#667080"}},null,-1),fs=[hs,vs],bs=["src"],ys={key:0,class:"invalid-feedback"},$s=["textContent"],xs={class:"list-unstyled"},Cs={class:"row mx-0"},ws={class:"mt-3"},gs=["disabled"],ks={__name:"ActivitiesComponent",setup(D){const l=Z("trans"),{activities:i,getActivities:x,getActivity:b,storeActivity:g,activityForm:o,destroyActivity:_}=ko(),{students:c,getStudents:T}=W(),{teachers:C,getTeachers:P}=Q(),S=async()=>{await g(),o.value.response.status==200&&!o.value.update&&(o.value.show=!1,R.value=null)},y=async u=>{if(i.value.isProccessing=!0,u=await b(u.id),i.value.isProccessing=!1,!u)return;i.value.list=i.value.list.map(p=>p.id==u.id?u:p),o.value.show=!0;const f=u.students.map(p=>({student_id:p.id,post_title:p.pivot.post_title}));o.value.data={name:u.name,class:u.class,activity_date:u.activityDate,teacher_id:u.teacher.id,students:f,bg_image:u.bgImage.path},R.value=u.bgImage,o.value.update=u},U=()=>{o.value.show=!1,o.value.errors=[],R.value=null};z(()=>{o.value.show||(o.value.response=null,o.value.errors=[],o.value.update&&(o.value.data=o.value.defaultData,o.value.update=null))});const w=X(()=>{const u={...c.value.list};return Object.keys(u).forEach(f=>{o.value.data.students.hasOwnProperty(parseInt(f))&&delete u[f]}),u}),A=u=>{confirm(l("Do you really want to delete this record?"))&&_(u)},R=G(null),m=u=>{R.value=u};x();const a=u=>{o.value.data.students[u]={student_id:u,post_title:""}};c.value.data_type="select",T(),C.value.data_type="select",P();const s=G(null),v=u=>{s.value&&clearTimeout(s.value),i.value.search=u.target.value,s.value=setTimeout(()=>{x()},600)};return(u,f)=>(r(),d(V,null,[e("div",Vo,[e("div",null,[e("div",So,[e("h6",{class:"h7",textContent:n(t(l)("Activities"))},null,8,To),e("input",{type:"text",class:"form-control mb-2",style:{"max-width":"300px"},placeholder:t(l)("Search"),onKeyup:f[0]||(f[0]=p=>v(p))},null,40,Uo),e("div",Ao,[e("button",{class:"primary-button",onClick:f[1]||(f[1]=p=>t(o).show=!t(o).show)},n(t(l)("Add activity")),1)])])]),t(i).response?t(i).response.status!=200?(r(),d("div",{key:1,class:"text-center text-danger",textContent:n(t(i).response.data.message||t(i).response.statusText)},null,8,Eo)):t(i).list.length==0?(r(),d("div",Ro,n(t(l)("No Data")),1)):(r(!0),d(V,{key:3},M(t(i).list,p=>(r(),d("div",{class:"col-12 mb-5",key:p.id},[e("div",qo,[e("div",Mo,[e("div",No,[e("img",{src:p.bgImage.pathUrl,alt:p.name},null,8,Lo)])]),e("div",Oo,[e("div",null,[e("h6",jo,[e("span",{textContent:n(p.name)},null,8,Io)]),e("small",{class:"text-secondary",textContent:n(p.activityDateFormated)},null,8,Bo)]),e("div",null,[Go,q(" "+n(p.students.map(N=>N.name).join(", ")),1)]),e("div",Ho,[e("div",null,[Ko,e("span",{textContent:n(p.teacher.name)},null,8,Zo)]),e("div",null,[zo,e("span",{textContent:n(t(l)("Class")+" "+p.class)},null,8,Jo)])]),e("div",Wo,[e("button",{type:"button",class:"secondary-button me-1",onClick:N=>y(p)},"عرض التفاصيل",8,Qo),e("button",{type:"button",class:"primary-button me-1",onClick:N=>y(p)},es,8,Xo),e("button",{type:"button",onClick:N=>A(p),class:"button button-red"},ss,8,ts)])])])]))),128)):(r(),d("div",Do,Fo)),t(i).isProccessing&&t(i).response?(r(),d("div",ns,as)):F("",!0)]),t(i).list.length?(r(),L(K,{key:0,meta:t(i).response.data.meta,onUpdateList:t(x)},null,8,["meta","onUpdateList"])):F("",!0),t(o).show?(r(),L(j,{key:1,onCloseModal:f[9]||(f[9]=p=>U()),class:O({"w-800px":!0})},{default:k(()=>[e("div",is,[e("form",{onSubmit:f[8]||(f[8]=I(p=>S(),["prevent"]))},[e("div",rs,[e("div",ds,[h($,{errors:t(o).errors.bg_image,path:"activity-bgs",type:"file",modelValue:t(o).data.bg_image,"onUpdate:modelValue":f[2]||(f[2]=p=>t(o).data.bg_image=p),onOnFileUpload:m,help:t(l)("ضع صورة لغلاف النشاط")},{customLabel:k(()=>[e("div",us,[e("div",cs,[R.value?(r(),d("img",{key:1,src:R.value.pathUrl},null,8,bs)):(r(),d("div",ps,[e("i",ms,[(r(),d("svg",_s,fs))])]))])])]),_:1},8,["errors","modelValue","help"]),t(o).errors.bg_image?(r(),d("ul",ys,[(r(!0),d(V,null,M(t(o).errors.bg_image,p=>(r(),d("li",{textContent:n(p)},null,8,$s))),256))])):F("",!0)]),h($,{class:"col-md-12",errors:t(o).errors.name,label:'<ion-icon name="activity"></ion-icon>',placeholder:"Activity name",modelValue:t(o).data.name,"onUpdate:modelValue":f[3]||(f[3]=p=>t(o).data.name=p),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-6",type:"date",errors:t(o).errors.activity_date,label:'<ion-icon name="calendar"></ion-icon>',placeholder:"Activity date",modelValue:t(o).data.activity_date,"onUpdate:modelValue":f[4]||(f[4]=p=>t(o).data.activity_date=p),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-6",errors:t(o).errors.class,label:'<ion-icon name="bookmark"></ion-icon>',placeholder:"Class",modelValue:t(o).data.class,"onUpdate:modelValue":f[5]||(f[5]=p=>t(o).data.class=p),required:!0},null,8,["errors","modelValue"]),h($,{class:"col-md-12",type:"select",searchable:!0,label:'<ion-icon name="person"></ion-icon>',placeholder:"Activity leader",errors:t(o).errors.teacher_id,modelValue:t(o).data.teacher_id,"onUpdate:modelValue":f[6]||(f[6]=p=>t(o).data.teacher_id=p),options:t(C).list,required:!0},null,8,["errors","modelValue","options"]),h($,{class:"col-md-12",type:"select",isModel:!1,searchable:!0,label:'<ion-icon name="school"></ion-icon>',placeholder:"Participating students",errors:t(o).errors.students,onOnChange:a,options:w.value,required:!0},null,8,["errors","options"]),e("ul",xs,[(r(!0),d(V,null,M(t(o).data.students,(p,N)=>(r(),d("li",null,[e("div",Cs,[h($,{class:"col-md-6",label:'<ion-icon name="person"></ion-icon>',readonly:!0,modelValue:t(c).list[p.student_id]},null,8,["modelValue"]),h($,{class:"col-md-6",label:'<ion-icon name="person"></ion-icon>',placeholder:"Post title",modelValue:p.post_title,"onUpdate:modelValue":ee=>p.post_title=ee},null,8,["modelValue","onUpdate:modelValue"])])]))),256))])]),e("div",ws,[e("button",{type:"submit",class:"primary-button",disabled:t(o).processing},n(t(o).processing?t(l)("Please wait"):t(o).update?t(l)("Update"):t(l)("Save")),9,gs),e("button",{type:"button",class:"secondary-button ms-2",onClick:f[7]||(f[7]=p=>U())},n(t(l)("Close")),1)])],32)])]),_:1})):F("",!0)],64))}},Vs={class:"d-flex flex-wrap justify-content-between mb-4"},Ss=["textContent"],Ts={key:0,class:"text-center"},Us=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),As=[Us],Ds=["textContent"],Ps={key:2,class:"text-center"},Fs=e("th",null,"#",-1),Es={scope:"col"},Rs={scope:"col"},qs={scope:"col"},Ms={scope:"col"},Ns={scope:"col"},Ls={scope:"col"},Os=["textContent"],js=["textContent"],Is=["textContent"],Bs=["textContent"],Gs=["textContent"],Hs=["textContent"],Ks={key:4,class:"is-proccessing"},Zs=e("div",{class:"lds-ellipsis"},[e("div"),e("div"),e("div"),e("div")],-1),zs=[Zs],Js={__name:"SubscriptionPaymentsComponent",setup(D){const{makeFetchAllRef:l,fetchAll:i}=B(),x=`${window._app.url}/subscription/payment_history`,b=l(),g=async(o=null)=>{await i(o??x,b)};return g(),(o,_)=>(r(),L(H,null,{header:k(()=>[e("div",Vs,[e("h6",{class:"h7",textContent:n(o.trans("Payments history"))},null,8,Ss)])]),default:k(()=>[e("div",null,[t(b).response?t(b).response.status!=200?(r(),d("div",{key:1,class:"text-center text-danger",textContent:n(t(b).response.data.message||t(b).response.statusText)},null,8,Ds)):t(b).list.length==0?(r(),d("div",Ps,n(o.trans("No Data")),1)):(r(),d(V,{key:3},[h(J,null,{thead:k(()=>[e("tr",null,[Fs,e("th",Es,n(o.trans("Plan name")),1),e("th",Rs,n(o.trans("Payment method")),1),e("th",qs,n(o.trans("Period")),1),e("th",Ms,n(o.trans("Amount")),1),e("th",Ns,n(o.trans("Payment status")),1),e("th",Ls,n(o.trans("Comment")),1)])]),default:k(()=>[(r(!0),d(V,null,M(t(b).list,c=>(r(),d("tr",{key:c.id},[e("td",{scope:"row",textContent:n(c.id)},null,8,Os),e("td",{textContent:n(o.trans(c.plan.name))},null,8,js),e("td",{textContent:n(c.paymentMethodText)},null,8,Is),e("td",{textContent:n(c.subscriptionPeriodText)},null,8,Bs),e("td",null,n(c.amount+" "+o.trans(c.currencyText)),1),e("td",null,[e("span",{class:O(["badge","bg-"+c.status]),textContent:n(o.trans(c.statusText))},null,10,Gs)]),e("td",{style:{"white-space":"pre-wrap"},textContent:n(c.comment??"/")},null,8,Hs)]))),128))]),_:1}),h(K,{meta:t(b).response.data.meta,onUpdateList:g},null,8,["meta"])],64)):(r(),d("div",Ts,As)),t(b).isProccessing&&t(b).response?(r(),d("div",Ks,zs)):F("",!0)])]),_:1}))}},E=ae({});E.component("students-component",Xe);E.component("teachers-component",qt);E.component("radios-component",go);E.component("activities-component",ks);E.component("subscription-payments-component",Js);E.component("chartjs-component",te);E.component("navbar-notifications-component",oe);E.component("notifications-component",se);E.provide("trans",Y.translate);E.config.globalProperties.trans=Y.translate;E.config.globalProperties._app=window._app;E.config.compilerOptions.isCustomElement=D=>D.startsWith("ion-icon");E.mount("#app");
