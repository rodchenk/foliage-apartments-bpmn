package faktor;

import java.io.IOException;
import java.io.InputStream;
import java.util.HashMap;
import java.util.Map;
import java.util.TreeMap;
import java.util.logging.Logger;

import org.camunda.bpm.client.task.ExternalTask;
import org.camunda.bpm.client.task.ExternalTaskHandler;
import org.camunda.bpm.client.task.ExternalTaskService;
import org.camunda.bpm.dmn.engine.DmnDecision;
import org.camunda.bpm.dmn.engine.DmnDecisionTableResult;
import org.camunda.bpm.dmn.engine.DmnEngine;
import org.camunda.bpm.dmn.engine.DmnEngineConfiguration;
import org.camunda.bpm.engine.variable.VariableMap;
import org.camunda.bpm.engine.variable.Variables;

public class FaktorWorker implements ExternalTaskHandler{
	
	private static final Logger sLogger = Logger.getLogger(FaktorWorker.class.getName());
	
	public void execute(ExternalTask externalTask, ExternalTaskService externalTaskService) {
		sLogger.info("DMN-Worker has been started");
			
		Map<String, Object> m = externalTask.getAllVariables();

		@SuppressWarnings("unchecked")
		TreeMap<Object, Object> days = (TreeMap<Object,Object>) m.get("Day");
		
		Map<String, Map<String, Boolean>> map = new HashMap<>();

		days.forEach((key, value) -> {
			Map<String, Boolean> temp = new HashMap<>(); 
			String val = value.toString().replaceAll("\\{", "").replaceAll("\\}", "");
			String[]arrays = val.split(",");
			for(int i = 0; i < arrays.length; i++) {
				String [] anotherArray = arrays[i].split("=");
				temp.put(anotherArray[0].trim(), Boolean.valueOf(anotherArray[1].trim()));
			}
			
			map.put(key.toString(), temp);
		});
		
		Map<String, Double> faktorMap = new HashMap<>();
		
		map.forEach((key, value) -> {
			faktorMap.put(key, calcFaktor(value.get("Weekend"), value.get("Holiday")));
		});
		
		faktorMap.forEach((key, value) -> {
			System.out.println(key + " " + value + " price is " + value);
		});
		Map<String, Object> data = new HashMap<>();
		
		data.put("Faktor", faktorMap);
		externalTaskService.complete(externalTask, data);
	}
	
	/**
	 * @author Mischa
	 * @param weekend {@link Boolean} true if day is weekend, false otherwise
	 * @param holiday {@link Boolean} true if day if holiday, false otherwise
	 * @return {@link Double} Factor from DMN (between 1 and 1.4)
	 */
	private double calcFaktor(boolean weekend, boolean holiday) {
		VariableMap variables = Variables.putValue("Weekend", weekend).putValue("Holiday", holiday);
		DmnEngine dmnEngine = DmnEngineConfiguration.createDefaultDmnEngineConfiguration().buildEngine();
		InputStream inputStream = FaktorDecision.class.getResourceAsStream("faktor_berechnen.xml");
		
		try {
			DmnDecision decision = dmnEngine.parseDecision("FaktorBerechnen", inputStream);
			DmnDecisionTableResult result = dmnEngine.evaluateDecisionTable(decision, variables);
		
			return result.getSingleResult().getSingleEntry();
			
		}finally {
			try {
				inputStream.close();
			}
			catch (IOException e) {
				System.err.println("Could not close stream: " + e.getMessage());
			}
		}
	}
	
}
