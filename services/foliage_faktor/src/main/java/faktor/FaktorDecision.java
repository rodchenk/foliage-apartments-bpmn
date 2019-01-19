package faktor;

import org.camunda.bpm.client.ExternalTaskClient;
import java.util.logging.Logger;

public class FaktorDecision {
	
	private static final Logger sLogger = Logger.getLogger(FaktorDecision.class.getName());
	private static final String PROCESS = "FaktorBerechnen";

	public static void main(String[] args) {
		
		sLogger.info("1. The FaktorDecision process has been started");
		
		ExternalTaskClient client = ExternalTaskClient.create().baseUrl("http://localhost:8080/engine-rest/").asyncResponseTimeout(10000).build();
		client.subscribe(PROCESS).lockDuration(1000).handler(new FaktorWorker()).open();
	}
}
