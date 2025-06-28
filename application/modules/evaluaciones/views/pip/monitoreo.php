<style>
.panel{
    margin-bottom: 2px;
}
.list-group-item:first-child{
    border-top-left-radius: unset;
    border-top-right-radius: unset;
}
.list-group-item {
    border-left: 0px;
    border-right: 0px;
}
.btnComentario{
    text-align:right;
    cursor:pointer;
}
.btnItem{
    float: right;
    padding-left: 10px;
}
#lista-mejora{
    padding-top:20px;
}
.list-group{
    padding-top:10px;
}

/* Vote list */
.vote-item {
  /* padding: 20px 25px; */
  background: #ffffff;
  border-top: 1px solid #e7eaec;
}
.vote-item:last-child {
  border-bottom: 1px solid #e7eaec;
}
.vote-item:hover {
  background: #fbfbfb;
}
.vote-actions {
  float: left;
  width: 30px;
  margin-right: 15px;
  text-align: center;
}
.vote-actions a {
  color: #1ab394;
  font-weight: 600;
}
.vote-actions {
  font-weight: 600;
}
.vote-title {
  display: block;
  color: inherit;
  font-size: 18px;
  font-weight: 600;
  margin-top: 5px;
  margin-bottom: 2px;
}
.vote-title:hover,
.vote-title:focus {
  color: inherit;
}
.vote-info,
.vote-info a {
  color: #b4b6b8;
  font-size: 12px;
}
.vote-info a {
  margin-right: 10px;
}
.vote-info a:hover {
  color: #423750;
}
.vote-icon {
  text-align: right;
  font-size: 38px;
  display: block;
  color: #e8e9ea;
}
.vote-icon.active {
  color: #423750;
}
.body.body-small .vote-icon {
  display: none;
}
/* Vote list */
.profile-content {
  border-top: none !important;
}
.profile-stats {
  margin-right: 10px;
}
.profile-image {
  width: 120px;
  float: left;
}
.profile-image img {
  width: 96px;
  height: 96px;
}
.profile-info {
  margin-left: 120px;
}
.feed-activity-list .feed-element {
  border-bottom: 1px solid #e7eaec;
}
.feed-element:first-child {
  margin-top: 0;
}
/* .feed-element {
  padding-bottom: 15px;
} */
.feed-element,
.feed-element .media {
  margin-top: 15px;
}
.feed-element,
.media-body {
  overflow: hidden;
}
.feed-element > a img {
  margin-right: 10px;
}
.feed-element img.rounded-circle,
.dropdown-messages-box img.rounded-circle {
  width: 38px;
  height: 38px;
}
.feed-element .well {
  border: 1px solid #e7eaec;
  box-shadow: none;
  margin-top: 10px;
  margin-bottom: 5px;
  padding: 10px 20px;
  font-size: 11px;
  line-height: 16px;
}
.feed-element .actions {
  margin-top: 10px;
}
.feed-element .photos {
  margin: 10px 0;
}
.dropdown-messages-box .dropdown-item:focus,
.dropdown-messages-box .dropdown-item:hover {
  background-color: inherit;
}
.feed-photo {
  max-height: 180px;
  border-radius: 4px;
  overflow: hidden;
  margin-right: 10px;
  margin-bottom: 10px;
}
.file-list li {
  padding: 5px 10px;
  font-size: 11px;
  border-radius: 2px;
  border: 1px solid #e7eaec;
  margin-bottom: 5px;
}
.file-list li a {
  color: inherit;
}
.file-list li a:hover {
  color: #1ab394;
}
.user-friends img {
  width: 42px;
  height: 42px;
  margin-bottom: 5px;
  margin-right: 5px;
}
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
      <div id="idM" data-id="<?=$id?>"></div>
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Seguimiento PIP</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li> <a href="<?= base_url() ?>miInfo#PIP">PIP</a></li>
                <li><a class="active">Seguimiento PIP</a></li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container">
  <input id="usuarioLog" type="hidden" value="<?=$this->tank_auth->get_idPersona()?>">
    <div id="PIP">
    </div>
</section>
<section style="padding-top: 25px;">

</section>
<script>
 $(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");
    const Monitor = new MonitoreoPIP({
        selector:'#PIP',
        getData: '',
        callbackSuccess: function (response) {
        }
    });
    Monitor.init();

});
</script>