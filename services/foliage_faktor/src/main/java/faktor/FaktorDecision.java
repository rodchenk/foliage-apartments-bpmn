package faktor;

import java.io.IOException;

import org.camunda.bpm.client.ExternalTaskClient;
import org.camunda.bpm.dmn.engine.DmnDecision;
import org.camunda.bpm.dmn.engine.DmnDecisionTableResult;
import org.camunda.bpm.dmn.engine.DmnEngine;
import org.camunda.bpm.dmn.engine.DmnEngineConfiguration;
import org.camunda.bpm.engine.variable.VariableMap;
import org.camunda.bpm.engine.variable.Variables;

import java.io.InputStream;
import java.util.logging.Logger;

public class FaktorDecision {
	
	private static final Logger sLogger = Logger.getLogger(FaktorDecision.class.getName());
	private static final String PROCESS = "FaktorBerechnen";

	public static void main(String[] args) {
		
		sLogger.info("1. The FaktorDecision process has been started");
		
		ExternalTaskClient client = ExternalTaskClient.create().baseUrl("http://localhost:8080/engine-rest/").asyncResponseTimeout(10000).build();
		client.subscribe(PROCESS).lockDuration(1000).handler(new FaktorWorker()).open();

//		VariableMap variables = Variables.putValue("Weekend", true)
//			      						 .putValue("Holiday", true);
//
//		// create a new default DMN engine
//		DmnEngine dmnEngine = DmnEngineConfiguration.createDefaultDmnEngineConfiguration().buildEngine();
//		
//		// parse decision from resource input stream
//		InputStream inputStream = FaktorDecision.class.getResourceAsStream("faktor_berechnen.xml");
//		sLogger.info("2. " + inputStream);
//		try {
//		  DmnDecision decision = dmnEngine.parseDecision("FaktorBerechnen", inputStream);
//		
//		  // evaluate decision
//		  DmnDecisionTableResult result = dmnEngine.evaluateDecisionTable(decision, variables);
//		
//		  // print result
//		  String faktor = Double.toString(result.getSingleResult().getSingleEntry());
//		  
//		  System.out.println("Faktor ist: " + faktor);
//		
//		}
//		finally {
//			try {
//				inputStream.close();
//			}
//			catch (IOException e) {
//				System.err.println("Could not close stream: " + e.getMessage());
//			}
//		}
	}
}
