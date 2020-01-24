<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="styles.css" />
  </head>
  <body>
    <style>
      body {
        width: 100vw;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background:url("background.jpg");
        overflow: hidden;
      }
      .card {
        display: grid;
        grid-template-columns: 300px;
        grid-template-rows: 210px 210px 80px;
        grid-template-areas: "image" "text" "stats";

        border-radius: 18px;
        background: white;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.9);
        font-family: roboto;
        text-align: center;


        transition: 0.5s ease;
        cursor: pointer;
        margin:30px;
      }
      .card-image {
        grid-area: image;
        background: url("img1.jpg");
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        background-size: cover;
      }

      .card-text {
        grid-area: text;
        margin: 25px;
      }
      .card-text .date {
        color: rgb(255, 7, 110);
        font-size:25px;
      }
      .card-text p {
        color: grey;
        font-size:15px;
        font-weight: 300;
      }
      .card-text h2 {
        margin-top:0px;
        font-size:28px;
      }
      .card-stats {
        grid-area: stats; 
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-template-rows: 1fr;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        background: rgb(255, 7, 110);
      }
      .card-stats .stat {
        padding:10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: white;
      }
      .card-stats .border {
        border-left: 1px solid rgb(172, 26, 87);
        border-right: 1px solid rgb(172, 26, 87);
      }
      .card-stats .value{
        font-size:22px;
        font-weight: 500;
      }
      .card-stats .value sup{
        font-size:12px;
      }
      .card-stats .type{
        font-size:11px;
        font-weight: 300;
        text-transform: uppercase;
      }
      .card-image.card2 {
        background: url("felicitaciones.jpg");
        background-size: cover;
      }
      .card-text.card2 .date {
        color: rgb(255, 77, 7);
      }
      .card-stats.card2 .border {
        border-left: 1px solid rgb(185, 67, 20);
        border-right: 1px solid rgb(185, 67, 20);
      }
      .card-stats.card2 {
        background: rgb(255, 77, 7);
      }
      /*card3*/
      .card-image.card3 {
        background: url("img3.jpg");
        background-size: cover;
      }
      .card-text.card3 .date {
        color: rgb(0, 189, 63);
      }
      .card-stats.card3 .border {
        border-left: 1px solid rgb(14, 122, 50);
        border-right: 1px solid rgb(14, 122, 50);
      }
      .card-stats.card3 {
        background: rgb(0, 189, 63);
      }
    </style>
    <div class="card">
      <div class="card-image card2"></div>
      <div class="card-text card2">
        <h1 class="date">Winky Coffe</h1>
        <h2>Te desea un feliz Cumpleaños {{ $cliente->perfil_nombre }}</h2>
        <p>Acude a nuestras sucursales y obtener un grandioso descuento</p>
      </div>
    </div>
  </body>
</html>
