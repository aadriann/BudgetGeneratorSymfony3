El proyecto fue desarrollado sobre un wamp, donde el servidor apache capaba algunas conexiones via get de angular.
Esta extensión de chrome lo soluciona: https://chrome.google.com/webstore/detail/allow-control-allow-origi/nlfbmbojpeacfghkpbjhddihlkkiljbi

El proyecto esta hecho en Symfony3 y Angular 1.6. El controlador principal contiene todas las acciones que puede llevar a cabo la aplicación.

La clase BudgetRepository contiene todo el proceso de las llamadas que hace el front para solicitar o modificar datos.

El front es un sencillo html, manejado con angular y twig que habilita o deshabilita acciones segun los estados de los elementos.