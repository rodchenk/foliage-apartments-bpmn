package faktor;

import java.util.HashMap;
import java.util.Map;
import java.util.TreeMap;
import java.util.logging.Logger;

import org.camunda.bpm.client.task.ExternalTask;
import org.camunda.bpm.client.task.ExternalTaskHandler;
import org.camunda.bpm.client.task.ExternalTaskService;

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
			String val = value.toString().replaceAll("\\{", "").replaceAll("\\}", "");;
//			String val2 = val.replaceAll("\\{", "").replaceAll("\\}", "");
//			String val3 = val2.replaceAll("\\}", "");
			String[]arrays = val.split(",");
			for(int i = 0; i < arrays.length; i++) {
				String [] anotherArray = arrays[i].split("=");
				temp.put(anotherArray[0].trim(), Boolean.valueOf(anotherArray[1].trim()));
			}
			
			map.put(key.toString(), temp);
		});
		
		map.forEach((key, value) -> {
			System.out.println(key + " | " + "Holiady: " + value.get("Holiday") + "; Weekend: " + value.get("Weekend"));
		});

	}
	
}
