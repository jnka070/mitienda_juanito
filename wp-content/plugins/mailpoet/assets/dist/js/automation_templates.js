"use strict";(globalThis.webpackChunk=globalThis.webpackChunk||[]).push([[726],{18325:(t,e,a)=>{var o=a(79124),n=a(59437),i=a(78631),l=a(94195),s=a(57450),r=a(29975),c=a(7378),m=a(66248),u=a(51047),d=a(20363),h=a(19669),p=a(86106);function _({showModal:t,onClose:e}){return t?(0,p.jsx)(d.D,{onRequestClose:e,tracking:{utm_medium:"upsell_modal",utm_campaign:"create_automation_from_scratch"},children:(0,n.__)("Creating custom automations is a premium feature.","mailpoet")}):null}function g({variant:t="secondary"}){const[e,a]=(0,c.useState)(!1),[o,i]=(0,c.useState)(null),[l,s]=(0,c.useState)(!1),r=(0,c.useCallback)((()=>{!function(t,e){u.Hooks.applyFilters("mailpoet.automation.templates.from_scratch_button",(()=>{s(!1),a(!0)}))(e)}(0,i)}),[]);return(0,p.jsxs)(p.Fragment,{children:[o&&(0,p.jsx)(h.$,{type:"error",closable:!0,timeout:!1,children:(0,p.jsx)("p",{children:o})}),(0,p.jsx)(m.Ay,{variant:t,isBusy:l&&"link"!==t,disabled:l,onClick:()=>{s(!0),r()},children:(0,n.__)("Create custom automation","mailpoet")}),(0,p.jsx)(_,{showModal:e,onClose:()=>{a(!1),s(!1)}})]})}var x=a(83586),j=a(43318),w=a(55494),b=a(71054);const f=[{name:"all",title:(0,p.jsx)(w.Ic,{title:(0,n.__)("All","mailpoet"),count:l.X.length})},...l.s.map((t=>({...t,count:l.X.filter((e=>e.category===t.slug)).length}))).filter((({count:t})=>t>0)).map((({name:t,slug:e,count:a})=>({name:e,title:(0,p.jsx)(w.Ic,{title:t,count:a})})))];function k(){const t=new URLSearchParams(window.location.search),e=t.get("loadedvia"),a=t.get("initialTab");return"woo_multichannel_dashboard"===e&&window.MailPoet.trackEvent("MailPoet - WooCommerce Multichannel Marketing dashboard > Automation template selection page",{"WooCommerce version":window.mailpoet_woocommerce_version}),(0,p.jsxs)("div",{className:"mailpoet-main-container",children:[(0,p.jsx)(r.x,{}),(0,p.jsx)(x.z,{heading:(0,n.__)("Start with a template","mailpoet"),headingPrefix:(0,p.jsx)(x.o,{href:j.U.urls.automationListing,label:(0,n.__)("Back to automation list","mailpoet")}),children:(0,p.jsx)(g,{})}),(0,p.jsx)(w.Kp,{tabs:f,initialTabName:a,children:t=>(0,p.jsx)(b.i,{templates:l.X.filter((e=>"all"===t.name||e.category===t.name))})}),(0,p.jsxs)(w.wi,{children:[(0,p.jsx)("p",{children:(0,n.__)("Can’t find what you’re looking for?","mailpoet")}),(0,p.jsx)(g,{variant:"link"})]})]})}window.addEventListener("DOMContentLoaded",(()=>{const t=document.getElementById("mailpoet_automation_templates");t&&((0,i.registerTranslations)(),(0,s.b)(),(0,o.H)(t).render((0,p.jsx)(k,{})))}))},41669:t=>{t.exports=jQuery}},t=>{t.O(0,[223],(()=>t(t.s=18325))),t.O()}]);