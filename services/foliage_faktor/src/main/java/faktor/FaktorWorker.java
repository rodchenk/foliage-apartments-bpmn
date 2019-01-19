package faktor;

import java.util.logging.Logger;

import org.camunda.bpm.client.task.ExternalTask;
import org.camunda.bpm.client.task.ExternalTaskHandler;
import org.camunda.bpm.client.task.ExternalTaskService;

public class FaktorWorker implements ExternalTaskHandler{
	
	private static final Logger sLogger = Logger.getLogger(FaktorWorker.class.getName());
	
	public void execute(ExternalTask externalTask, ExternalTaskService externalTaskService) {
		sLogger.info("DMN-Worker has been started");
	}
}
