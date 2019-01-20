# BPMN Implementierung - Reservierung von Apartment

In dieser Dokumentation ist beschrieben, wie wir das Process der Apartment-Reservierung implementiert haben. Als Beispiel haben wir eigene Webseite (foliage Apartment) entwickelt, wo die Gastgeber Ihre Apartments anbieten. Bei der Implementierung des Processes wurden die folgenden Technologien verwendet:

   * Apache WebServer
   * Tomcat WebServer
   * CakePHP
   * MySQL Datenbank
   * Maven und Plugin shade https://github.com/apache/maven-shade-plugin
   * Camunda https://github.com/camunda/camunda-bpm-platform
   * Google Gson https://github.com/google/gson
   * RestAPI für Feiertage https://feiertage-api.de
   * J2EE, Java SE 1.8
   * Git als Version Control System
   * Bootstrap, Fontawesome und GoogleFonts für das Design 
    
Das Model wurde in Camunda Modeler gemacht. Dies besteht aus zwei Services (extern implementiert), einem DMN (extern implementiert), einem UserTask (wird durch API Aufruf erledigt) und einem SendTask (extern implementiert mit javax.mail).
![Image of BPMN](docs/bpmn.PNG)

# Vorprocess. Apartmentauswahl

![Image of BPMN](docs/start.web.PNG)

Auf der Startseite befinden sich mehrere Apartments. Beim Klicken auf eins davon landet man auf **/apartment/:id**. Hier sind weitere Informationen angezeigt, wie z.B. Anbieter, Preis und weiteres. Unten links muss man einen Zeitraum auswählen, für welchen man das Apartment reservieren möchte. 

![Image of BPMN](docs/page.web.PNG)

Beim Klicken auf das Button **Prüfen**, wird eine API Anfrage (/engine-rest/process-definition/:definition_key/start') an Camunda Engine gesendet und es wird als RequestBody ein JSON Objekt übergeben, welches ApartmentID und Von- und Bis-Datums enthält. 
Das DefinitionKey wird beim Deployen des Models generiert. Diese und alle weiteren API Anfragen werden aus Sicherheitsgründen ausschliesslich im BackEnd durchgeführt und bearbeitet. FrontEnd seitig werden nur entsprechende Variablen gesendet, die dann im BackEnd validiert werden und entsprechende Funktionen aufrufen. 

# Schritt 1. Availality Checker Service

