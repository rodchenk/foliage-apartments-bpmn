package availability;

import java.util.logging.Logger;
import org.camunda.bpm.client.ExternalTaskClient;

public class CheckWorker {
	
	private static final Logger sLogger = Logger.getLogger(CheckWorker.class.getName());
	private static String PROCESS = "AvailabilityWorker";

	public static void main(String[] args) {
		sLogger.info("1. The CheckWorker process has been started");
				
		ExternalTaskClient client = ExternalTaskClient.create().baseUrl("http://localhost:8080/engine-rest/").asyncResponseTimeout(10000).build();
		client.subscribe(PROCESS).lockDuration(1000).handler(new FoliageServiceWorker()).open();
	}
}