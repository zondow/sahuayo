<style>
.bell{
  display:block;
  width: 40px;
  height: 40px;
  margin:60% 12%;
  color: #9e9e9e;
  -webkit-animation: ring 4s .7s ease-in-out infinite;
  -webkit-transform-origin: 50% 4px;
  -moz-animation: ring 4s .7s ease-in-out infinite;
  -moz-transform-origin: 50% 4px;
  animation: ring 4s .7s ease-in-out infinite;
  transform-origin: 50% 4px;
}

@-webkit-keyframes ring {
  0% { -webkit-transform: rotateZ(0); }
  1% { -webkit-transform: rotateZ(30deg); }
  3% { -webkit-transform: rotateZ(-28deg); }
  5% { -webkit-transform: rotateZ(34deg); }
  7% { -webkit-transform: rotateZ(-32deg); }
  9% { -webkit-transform: rotateZ(30deg); }
  11% { -webkit-transform: rotateZ(-28deg); }
  13% { -webkit-transform: rotateZ(26deg); }
  15% { -webkit-transform: rotateZ(-24deg); }
  17% { -webkit-transform: rotateZ(22deg); }
  19% { -webkit-transform: rotateZ(-20deg); }
  21% { -webkit-transform: rotateZ(18deg); }
  23% { -webkit-transform: rotateZ(-16deg); }
  25% { -webkit-transform: rotateZ(14deg); }
  27% { -webkit-transform: rotateZ(-12deg); }
  29% { -webkit-transform: rotateZ(10deg); }
  31% { -webkit-transform: rotateZ(-8deg); }
  33% { -webkit-transform: rotateZ(6deg); }
  35% { -webkit-transform: rotateZ(-4deg); }
  37% { -webkit-transform: rotateZ(2deg); }
  39% { -webkit-transform: rotateZ(-1deg); }
  41% { -webkit-transform: rotateZ(1deg); }

  43% { -webkit-transform: rotateZ(0); }
  100% { -webkit-transform: rotateZ(0); }
}

@-moz-keyframes ring {
  0% { -moz-transform: rotate(0); }
  1% { -moz-transform: rotate(30deg); }
  3% { -moz-transform: rotate(-28deg); }
  5% { -moz-transform: rotate(34deg); }
  7% { -moz-transform: rotate(-32deg); }
  9% { -moz-transform: rotate(30deg); }
  11% { -moz-transform: rotate(-28deg); }
  13% { -moz-transform: rotate(26deg); }
  15% { -moz-transform: rotate(-24deg); }
  17% { -moz-transform: rotate(22deg); }
  19% { -moz-transform: rotate(-20deg); }
  21% { -moz-transform: rotate(18deg); }
  23% { -moz-transform: rotate(-16deg); }
  25% { -moz-transform: rotate(14deg); }
  27% { -moz-transform: rotate(-12deg); }
  29% { -moz-transform: rotate(10deg); }
  31% { -moz-transform: rotate(-8deg); }
  33% { -moz-transform: rotate(6deg); }
  35% { -moz-transform: rotate(-4deg); }
  37% { -moz-transform: rotate(2deg); }
  39% { -moz-transform: rotate(-1deg); }
  41% { -moz-transform: rotate(1deg); }

  43% { -moz-transform: rotate(0); }
  100% { -moz-transform: rotate(0); }
}

@keyframes ring {
  0% { transform: rotate(0); }
  1% { transform: rotate(30deg); }
  3% { transform: rotate(-28deg); }
  5% { transform: rotate(34deg); }
  7% { transform: rotate(-32deg); }
  9% { transform: rotate(30deg); }
  11% { transform: rotate(-28deg); }
  13% { transform: rotate(26deg); }
  15% { transform: rotate(-24deg); }
  17% { transform: rotate(22deg); }
  19% { transform: rotate(-20deg); }
  21% { transform: rotate(18deg); }
  23% { transform: rotate(-16deg); }
  25% { transform: rotate(14deg); }
  27% { transform: rotate(-12deg); }
  29% { transform: rotate(10deg); }
  31% { transform: rotate(-8deg); }
  33% { transform: rotate(6deg); }
  35% { transform: rotate(-4deg); }
  37% { transform: rotate(2deg); }
  39% { transform: rotate(-1deg); }
  41% { transform: rotate(1deg); }

  43% { transform: rotate(0); }
  100% { transform: rotate(0); }
}

.ticketIcon{
  width: 25px;
    height: 25px;
    display: inline-table;
    position: relative;
    background-position: center center;
  animation:ringTicket 1.6s linear infinite;
}

@keyframes ringTicket{
	0% { transform: rotate(0deg) }
	5% { transform: rotate(0deg) }
	15% { transform: rotate(0deg) }
	25% { transform: rotate(20deg) }
	35% { transform: rotate(-15deg) }
	45% { transform: rotate(10deg) }
	55% { transform: rotate(-5deg) }
	60% { transform: rotate(0deg) }
	100% { transform: rotate(0deg) }
}

</style>
<li class="dropdown notification-list">
    <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <i id="bell" class="fe-bell noti-icon "></i>
        <span class="badge badge-danger rounded-circle noti-icon-badge" id="totalNotif">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-lg" style="border-radius: 15px;width:410px" >
        <div class="dropdown-item noti-title">
            <h5 class="m-0">
              <span class="float-right">
                  <a href="#" class="text-dark borrarNotificaciones" data-toggle="tooltip" data-original-title="Borrar notificaciones">
                      <i class="fe-trash"></i>
                  </a>
              </span>
                Notificaciones
            </h5>
        </div>
        <div id="items" class="slimscroll noti-scroll" style="height:500px !important;">
        </div>
    </div>
</li>
<?php if (isSolicitanteMesa() || administradorID()) {?>
<!-- Ticket -->
<li class="dropdown notification-list">
    <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <i id="bellTicket" class="dripicons-ticket noti-icon "></i>
        <span class="badge badge-danger rounded-circle noti-icon-badge" id="totalNotifTicket">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-lg" style="border-radius: 15px;width:410px" >
        <div class="dropdown-item noti-title">
            <h5 class="m-0">
              <span class="float-right">
                  <a href="#" class="text-dark borrarNotificacionesTicket" data-toggle="tooltip" data-original-title="Borrar notificaciones">
                      <i class="fe-trash"></i>
                  </a>
              </span>
                Notificaciones
            </h5>
        </div>
        <div id="itemsTicket" class="slimscroll noti-scroll" style="height:500px !important;">
        </div>
    </div>
</li>
<?php } ?>