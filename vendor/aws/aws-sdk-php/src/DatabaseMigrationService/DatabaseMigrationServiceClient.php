<?php
namespace Aws\DatabaseMigrationService;

use Aws\AwsClient;

/**
 * This client is used to interact with the **AWS Database Migration Service** service.
 * @method \Aws\Result addTagsToResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise addTagsToResourceAsync(array $args = [])
 * @method \Aws\Result applyPendingMaintenanceAction(array $args = [])
 * @method \GuzzleHttp\Promise\Promise applyPendingMaintenanceActionAsync(array $args = [])
 * @method \Aws\Result batchStartRecommendations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchStartRecommendationsAsync(array $args = [])
 * @method \Aws\Result cancelReplicationTaskAssessmentRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise cancelReplicationTaskAssessmentRunAsync(array $args = [])
 * @method \Aws\Result createDataProvider(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createDataProviderAsync(array $args = [])
 * @method \Aws\Result createEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createEndpointAsync(array $args = [])
 * @method \Aws\Result createEventSubscription(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createEventSubscriptionAsync(array $args = [])
 * @method \Aws\Result createFleetAdvisorCollector(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createFleetAdvisorCollectorAsync(array $args = [])
 * @method \Aws\Result createInstanceProfile(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createInstanceProfileAsync(array $args = [])
 * @method \Aws\Result createMigrationProject(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createMigrationProjectAsync(array $args = [])
 * @method \Aws\Result createReplicationConfig(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createReplicationConfigAsync(array $args = [])
 * @method \Aws\Result createReplicationInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createReplicationInstanceAsync(array $args = [])
 * @method \Aws\Result createReplicationSubnetGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createReplicationSubnetGroupAsync(array $args = [])
 * @method \Aws\Result createReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createReplicationTaskAsync(array $args = [])
 * @method \Aws\Result deleteCertificate(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteCertificateAsync(array $args = [])
 * @method \Aws\Result deleteConnection(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteConnectionAsync(array $args = [])
 * @method \Aws\Result deleteDataProvider(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteDataProviderAsync(array $args = [])
 * @method \Aws\Result deleteEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteEndpointAsync(array $args = [])
 * @method \Aws\Result deleteEventSubscription(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteEventSubscriptionAsync(array $args = [])
 * @method \Aws\Result deleteFleetAdvisorCollector(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteFleetAdvisorCollectorAsync(array $args = [])
 * @method \Aws\Result deleteFleetAdvisorDatabases(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteFleetAdvisorDatabasesAsync(array $args = [])
 * @method \Aws\Result deleteInstanceProfile(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteInstanceProfileAsync(array $args = [])
 * @method \Aws\Result deleteMigrationProject(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteMigrationProjectAsync(array $args = [])
 * @method \Aws\Result deleteReplicationConfig(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteReplicationConfigAsync(array $args = [])
 * @method \Aws\Result deleteReplicationInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteReplicationInstanceAsync(array $args = [])
 * @method \Aws\Result deleteReplicationSubnetGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteReplicationSubnetGroupAsync(array $args = [])
 * @method \Aws\Result deleteReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteReplicationTaskAsync(array $args = [])
 * @method \Aws\Result deleteReplicationTaskAssessmentRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteReplicationTaskAssessmentRunAsync(array $args = [])
 * @method \Aws\Result describeAccountAttributes(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeAccountAttributesAsync(array $args = [])
 * @method \Aws\Result describeApplicableIndividualAssessments(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeApplicableIndividualAssessmentsAsync(array $args = [])
 * @method \Aws\Result describeCertificates(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeCertificatesAsync(array $args = [])
 * @method \Aws\Result describeConnections(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeConnectionsAsync(array $args = [])
 * @method \Aws\Result describeConversionConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeConversionConfigurationAsync(array $args = [])
 * @method \Aws\Result describeDataProviders(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeDataProvidersAsync(array $args = [])
 * @method \Aws\Result describeEndpointSettings(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEndpointSettingsAsync(array $args = [])
 * @method \Aws\Result describeEndpointTypes(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEndpointTypesAsync(array $args = [])
 * @method \Aws\Result describeEndpoints(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEndpointsAsync(array $args = [])
 * @method \Aws\Result describeEngineVersions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEngineVersionsAsync(array $args = [])
 * @method \Aws\Result describeEventCategories(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEventCategoriesAsync(array $args = [])
 * @method \Aws\Result describeEventSubscriptions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEventSubscriptionsAsync(array $args = [])
 * @method \Aws\Result describeEvents(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEventsAsync(array $args = [])
 * @method \Aws\Result describeExtensionPackAssociations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeExtensionPackAssociationsAsync(array $args = [])
 * @method \Aws\Result describeFleetAdvisorCollectors(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeFleetAdvisorCollectorsAsync(array $args = [])
 * @method \Aws\Result describeFleetAdvisorDatabases(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeFleetAdvisorDatabasesAsync(array $args = [])
 * @method \Aws\Result describeFleetAdvisorLsaAnalysis(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeFleetAdvisorLsaAnalysisAsync(array $args = [])
 * @method \Aws\Result describeFleetAdvisorSchemaObjectSummary(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeFleetAdvisorSchemaObjectSummaryAsync(array $args = [])
 * @method \Aws\Result describeFleetAdvisorSchemas(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeFleetAdvisorSchemasAsync(array $args = [])
 * @method \Aws\Result describeInstanceProfiles(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeInstanceProfilesAsync(array $args = [])
 * @method \Aws\Result describeMetadataModelAssessments(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeMetadataModelAssessmentsAsync(array $args = [])
 * @method \Aws\Result describeMetadataModelConversions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeMetadataModelConversionsAsync(array $args = [])
 * @method \Aws\Result describeMetadataModelExportsAsScript(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeMetadataModelExportsAsScriptAsync(array $args = [])
 * @method \Aws\Result describeMetadataModelExportsToTarget(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeMetadataModelExportsToTargetAsync(array $args = [])
 * @method \Aws\Result describeMetadataModelImports(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeMetadataModelImportsAsync(array $args = [])
 * @method \Aws\Result describeMigrationProjects(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeMigrationProjectsAsync(array $args = [])
 * @method \Aws\Result describeOrderableReplicationInstances(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeOrderableReplicationInstancesAsync(array $args = [])
 * @method \Aws\Result describePendingMaintenanceActions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describePendingMaintenanceActionsAsync(array $args = [])
 * @method \Aws\Result describeRecommendationLimitations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeRecommendationLimitationsAsync(array $args = [])
 * @method \Aws\Result describeRecommendations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeRecommendationsAsync(array $args = [])
 * @method \Aws\Result describeRefreshSchemasStatus(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeRefreshSchemasStatusAsync(array $args = [])
 * @method \Aws\Result describeReplicationConfigs(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationConfigsAsync(array $args = [])
 * @method \Aws\Result describeReplicationInstanceTaskLogs(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationInstanceTaskLogsAsync(array $args = [])
 * @method \Aws\Result describeReplicationInstances(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationInstancesAsync(array $args = [])
 * @method \Aws\Result describeReplicationSubnetGroups(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationSubnetGroupsAsync(array $args = [])
 * @method \Aws\Result describeReplicationTableStatistics(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationTableStatisticsAsync(array $args = [])
 * @method \Aws\Result describeReplicationTaskAssessmentResults(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationTaskAssessmentResultsAsync(array $args = [])
 * @method \Aws\Result describeReplicationTaskAssessmentRuns(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationTaskAssessmentRunsAsync(array $args = [])
 * @method \Aws\Result describeReplicationTaskIndividualAssessments(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationTaskIndividualAssessmentsAsync(array $args = [])
 * @method \Aws\Result describeReplicationTasks(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationTasksAsync(array $args = [])
 * @method \Aws\Result describeReplications(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationsAsync(array $args = [])
 * @method \Aws\Result describeSchemas(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeSchemasAsync(array $args = [])
 * @method \Aws\Result describeTableStatistics(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeTableStatisticsAsync(array $args = [])
 * @method \Aws\Result exportMetadataModelAssessment(array $args = [])
 * @method \GuzzleHttp\Promise\Promise exportMetadataModelAssessmentAsync(array $args = [])
 * @method \Aws\Result importCertificate(array $args = [])
 * @method \GuzzleHttp\Promise\Promise importCertificateAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result modifyConversionConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyConversionConfigurationAsync(array $args = [])
 * @method \Aws\Result modifyDataProvider(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyDataProviderAsync(array $args = [])
 * @method \Aws\Result modifyEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyEndpointAsync(array $args = [])
 * @method \Aws\Result modifyEventSubscription(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyEventSubscriptionAsync(array $args = [])
 * @method \Aws\Result modifyInstanceProfile(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyInstanceProfileAsync(array $args = [])
 * @method \Aws\Result modifyMigrationProject(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyMigrationProjectAsync(array $args = [])
 * @method \Aws\Result modifyReplicationConfig(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyReplicationConfigAsync(array $args = [])
 * @method \Aws\Result modifyReplicationInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyReplicationInstanceAsync(array $args = [])
 * @method \Aws\Result modifyReplicationSubnetGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyReplicationSubnetGroupAsync(array $args = [])
 * @method \Aws\Result modifyReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyReplicationTaskAsync(array $args = [])
 * @method \Aws\Result moveReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise moveReplicationTaskAsync(array $args = [])
 * @method \Aws\Result rebootReplicationInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise rebootReplicationInstanceAsync(array $args = [])
 * @method \Aws\Result refreshSchemas(array $args = [])
 * @method \GuzzleHttp\Promise\Promise refreshSchemasAsync(array $args = [])
 * @method \Aws\Result reloadReplicationTables(array $args = [])
 * @method \GuzzleHttp\Promise\Promise reloadReplicationTablesAsync(array $args = [])
 * @method \Aws\Result reloadTables(array $args = [])
 * @method \GuzzleHttp\Promise\Promise reloadTablesAsync(array $args = [])
 * @method \Aws\Result removeTagsFromResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise removeTagsFromResourceAsync(array $args = [])
 * @method \Aws\Result runFleetAdvisorLsaAnalysis(array $args = [])
 * @method \GuzzleHttp\Promise\Promise runFleetAdvisorLsaAnalysisAsync(array $args = [])
 * @method \Aws\Result startExtensionPackAssociation(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startExtensionPackAssociationAsync(array $args = [])
 * @method \Aws\Result startMetadataModelAssessment(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startMetadataModelAssessmentAsync(array $args = [])
 * @method \Aws\Result startMetadataModelConversion(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startMetadataModelConversionAsync(array $args = [])
 * @method \Aws\Result startMetadataModelExportAsScript(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startMetadataModelExportAsScriptAsync(array $args = [])
 * @method \Aws\Result startMetadataModelExportToTarget(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startMetadataModelExportToTargetAsync(array $args = [])
 * @method \Aws\Result startMetadataModelImport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startMetadataModelImportAsync(array $args = [])
 * @method \Aws\Result startRecommendations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startRecommendationsAsync(array $args = [])
 * @method \Aws\Result startReplication(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startReplicationAsync(array $args = [])
 * @method \Aws\Result startReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startReplicationTaskAsync(array $args = [])
 * @method \Aws\Result startReplicationTaskAssessment(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startReplicationTaskAssessmentAsync(array $args = [])
 * @method \Aws\Result startReplicationTaskAssessmentRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startReplicationTaskAssessmentRunAsync(array $args = [])
 * @method \Aws\Result stopReplication(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopReplicationAsync(array $args = [])
 * @method \Aws\Result stopReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopReplicationTaskAsync(array $args = [])
 * @method \Aws\Result testConnection(array $args = [])
 * @method \GuzzleHttp\Promise\Promise testConnectionAsync(array $args = [])
 * @method \Aws\Result updateSubscriptionsToEventBridge(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateSubscriptionsToEventBridgeAsync(array $args = [])
 */
class DatabaseMigrationServiceClient extends AwsClient {}
