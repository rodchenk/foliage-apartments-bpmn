package notify;

import java.util.logging.Logger;

import org.camunda.bpm.client.ExternalTaskClient;


public class NotifyFoliageTask {
	
	private static final Logger sLogger = Logger.getLogger(NotifyFoliageTask.class.getName());
	private final static String PROCESS = "Notify";
	
	public static void main(String [] args) {
		sLogger.info("1. The NotifyFoliageTask process has been started");
		
		ExternalTaskClient client = ExternalTaskClient.create().baseUrl("http://localhost:8080/engine-rest/").asyncResponseTimeout(10000).build();
		client.subscribe(PROCESS).lockDuration(1000).handler(new NotifyFoliageService()).open();
	}
}
