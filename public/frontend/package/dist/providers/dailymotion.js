/*!
 * @license MIT
 * @name vlitejs
 * @version 7.0.0
 * @copyright 2024 Yoriiis
 */
function t(t,e){const i="dailymotion";if(window.VlitejsDailymotionQueue=window.VlitejsDailymotionQueue||[],void 0===window[i]){const t=document.createElement("script");t.async=!0,t.type="text/javascript",t.src=`https://geo.dailymotion.com/libs/player/${e.playerId}.js`,t.onload=()=>{window.VlitejsDailymotionQueue.forEach((t=>{t.initDailymotionPlayer().then((()=>{t.addSpecificEvents(),t.onReady()}))})),window.VlitejsDailymotionQueue=[]},document.getElementsByTagName("body")[0].appendChild(t)}return class extends t{constructor(t){super(t);this.params=Object.assign(Object.assign({},{controls:!1}),this.options.providerParams),this.events=[{type:"timeupdate",listener:super.onTimeUpdate},{type:"end",listener:super.onMediaEnded},{type:"playing",listener:this.onPlaying},{type:"waiting",listener:this.onWaiting}]}init(){this.waitUntilVideoIsReady().then((()=>{this.addSpecificEvents(),super.onReady()}))}waitUntilVideoIsReady(){return new window.Promise((t=>{void 0!==window[i]?this.initDailymotionPlayer().then(t):window.VlitejsDailymotionQueue.push(this)}))}initDailymotionPlayer(){return new window.Promise((t=>{window.dailymotion.createPlayer(this.media.getAttribute("id"),{video:this.media.getAttribute("data-dailymotion-id")}).then((e=>{this.instance=e,this.media=e.getRootNode();const{autostart:i}=this.instance.getSettings();["on","firstTimeViewable"].includes(i)&&(this.options.autoplay=!0),this.media.classList.add("vlite-js"),this.media.removeAttribute("style"),t()}))}))}addSpecificEvents(){this.events.forEach((t=>{this.instance.on(t.type,t.listener.bind(this))}))}getInstance(){return this.instance}getCurrentTime(){return this.instance.getState().then((t=>t.videoTime))}getDuration(){return this.instance.getState().then((t=>t.videoDuration))}methodPlay(){this.instance.play()}methodPause(){this.instance.pause()}methodSetVolume(t){this.instance.setVolume(t)}methodGetVolume(){return this.instance.getState().then((t=>t.playerVolume))}methodMute(){this.instance.setMute(!0)}methodUnMute(){this.instance.setMute(!1)}methodSeekTo(t){this.instance.seek(t)}onWaiting(){this.loading(!0)}onPlaying(){this.loading(!1)}removeSpecificEvents(){this.events.forEach((t=>{this.instance.off(t.type,t.listener)}))}destroy(){this.removeSpecificEvents(),this.instance.destroy(),super.destroy()}}}export{t as default};
