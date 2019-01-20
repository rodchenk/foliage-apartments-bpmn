package notify;

import java.util.Date;
import java.util.Properties;
import java.util.logging.Logger;

import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

import org.camunda.bpm.client.task.ExternalTask;
import org.camunda.bpm.client.task.ExternalTaskHandler;
import org.camunda.bpm.client.task.ExternalTaskService;

public class NotifyFoliageService implements ExternalTaskHandler{

	private static final Logger sLogger = Logger.getLogger(NotifyFoliageService.class.getName());
	private static final String EMAIL = "rodchenk@th-brandenburg.de";
	private static final String HOST = "mail.th-brandenburg.de";
	
	public void execute(ExternalTask externalTask, ExternalTaskService externalTaskService) {
		sLogger.info("2. NotifyService has been started");

		String text = "Ein Benutzer interessiert sich für Ihr Apartment in Zeitraum von " + 
					externalTask.getVariable("from") + 
					" bis " + 
					externalTask.getVariable("to") + 
					". Melden Sie sich an, um die Anfrage zu bestätigen." +
					'\n' + 
					'\n' + 
					"http://localhost/apartment/"+ externalTask.getVariable("id");
		
		sendEmail(text);
		
		externalTaskService.complete(externalTask);
	}
	
	private void sendEmail(String text) {
		String to = EMAIL, 
			   from = EMAIL;
		String host = HOST;
		String subject = "Neue Reservierung bei foliage Apartments";
		
		Properties properties = System.getProperties();
		properties.setProperty("mail.smtp.host", host);
		Session session = Session.getDefaultInstance(properties);

	      try {
	         MimeMessage message = new MimeMessage(session);
	         message.setFrom(new InternetAddress(from));
	         message.addRecipient(Message.RecipientType.TO, new InternetAddress(to));
	         message.setSubject(subject);
	         Date d = new Date();
	         message.setText(d.toString() + '\n' + text);

	         Transport.send(message);
	         sLogger.info("Message has been sent successfully");
	      } catch (MessagingException mex) {
	         mex.printStackTrace();
	         sLogger.warning("Something went wrong with E-mail");
	      }
	}
}
