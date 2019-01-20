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
    
# Modellierung. Camunda
Das Model wurde in Camunda Modeler gemacht. Dies besteht aus zwei Services (extern implementiert), einem DMN (extern implementiert), einem UserTask (wird durch API Aufruf erledigt) und einem SendTask (extern implementiert mit javax.mail).
![Image of BPMN](docs/bpmn.PNG)

# Idee. Dynamische Preise

Das Process soll die Preise für Apartments dynamisch berechnen. Die Berechnung geschieht basierend auf Grundpreis (ab *[num]* EUR) und auf den Tagen, auf die das Apartment reserviert wird. Je nach dem, ob es Wochenende oder Feiertage gibt, wird sich der Preis um ein Faktor erhöht. Dieser Faktor Wird in einem separatem Service mithilfe von DMN berechnet. Schliesslich bekommt man die Liste mit Tagen und jeweiligen Preisen pro Nacht. 

# Vorprocess. Apartmentauswahl

![Image of BPMN](docs/start.web.PNG)

Auf der Startseite befinden sich mehrere Apartments. Beim Klicken auf eins davon landet man auf **/apartment/:id**. Hier sind weitere Informationen angezeigt, wie z.B. Anbieter, Preis und weiteres. Unten links muss man einen Zeitraum auswählen, für welchen man das Apartment reservieren möchte. 

![Image of BPMN](docs/page.web.PNG)

Beim Klicken auf das Button **Prüfen**, wird eine API Anfrage
```
POST /engine-rest/process-definition/:definition_key/start
```
an Camunda Engine gesendet und es wird als RequestBody ein JSON Objekt übergeben, welches ApartmentID und Von- und Bis-Datums enthält. 
Das DefinitionKey wird beim Deployen des Models generiert. Diese und alle weiteren API Anfragen werden aus Sicherheitsgründen ausschliesslich im BackEnd durchgeführt und bearbeitet. FrontEnd seitig werden nur entsprechende Variablen gesendet, die dann im BackEnd validiert werden und entsprechende Funktionen aufrufen. 

# Schritt 1. Availality Checker Service

Nachdem das Process gestartet wurde, wird das erste Service mit externen Implementiereung aufgerufen. Das kann entweder über das Starten von /service/start_1_foliageAvailability.bat oder über cmd Befehl
```
  java -cp foliage_availability/target/apartments-availability-0.0.1-SNAPSHOT.jar availability.CheckWorker
```
![Image of BPMN](docs/step1.web.PNG)

Wenn das Process gestartet ist, erscheint ein entsprechendes Label (in diesem Fall *Verfügbarkeit wird geprüft*) und eine Animation. In Camunda Cockpit sieht man, das sich das Token auf dem ersten Service befindet. Das AvailabilityCheckerService erstellt eine Variable **Apartment**, befüllt sie mit übergebenen Daten (from, to, id) und prüft, ob diese Apartment in dem angegebenen Zeitraum verfügbar ist. Als Antwort wird an Camunda Engine ein boolischer Wert übergeben.

![Image of BPMN](docs/step1.camunda.PNG)

Als Antwort von camunda-engine API beim Starten des Process bekommt die Applikationen alle notwendigen Daten inkl. Process ID und Definition Key. Diese Daten werden für den späteren Verbrauch in Cookies gespeichert.
Wenn das Availability Checker Service ein false (d.h. Apartment ist nicht frei) zurückgeliefert hat, wird das Process gleich nach dem Gateway beendet. Das Gateway bekommt eine Variable ${available} und falls sie **true** ist, geht das Process weiter, ansonsten (default flow) wird es beendet und der Benutzer wird über die Nicht-Verfügbarkeit des Apartments benachrichtigt. Diese Daten bekommt die App durch den folgenden API Aufruf
```
GET /engine-rest/history/variable-instance?variableName=available&processInstanceIdIn=:id;
```

# Schritt 2. Day Checker Service

Danach wird das zweite Service Day Checker (auch entweder über cmd oder bat-datei **start_2_foliageDayChecker.bat**) gestartet. 

![Image of BPMN](docs/step11.web.PNG)

Dieses Service prüft den von Benutzer angegebenen Zeitraum auf zwei Eigenschaften: Feiertag und Wochenendetag. Für die erste Eigenschaft wird eine externe [RestAPI](https://feiertage-api.de) verwendet:
```
GET https://feiertage-api.de/api/?jahr=:year
```
Die Wochenendetage werden einfach mit Vergleich auf Calendar.Saturday und Calendar.Sunday geprüft. Schliesslich wird ein HashMap erstellt und es mit den Daten befühlt.

![Image of BPMN](docs/step2.camunda.PNG)
![Image of BPMN](docs/step2.data.camunda.PNG)

# Schritt 3. Calculate Factor Service
