<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Contactcenterinsights;

class GoogleCloudContactcenterinsightsV1alpha1AnalysisResultCallAnalysisMetadata extends \Google\Collection
{
  protected $collection_key = 'sentiments';
  /**
   * @var GoogleCloudContactcenterinsightsV1alpha1CallAnnotation[]
   */
  public $annotations;
  protected $annotationsType = GoogleCloudContactcenterinsightsV1alpha1CallAnnotation::class;
  protected $annotationsDataType = 'array';
  /**
   * @var GoogleCloudContactcenterinsightsV1alpha1Entity[]
   */
  public $entities;
  protected $entitiesType = GoogleCloudContactcenterinsightsV1alpha1Entity::class;
  protected $entitiesDataType = 'map';
  /**
   * @var GoogleCloudContactcenterinsightsV1alpha1Intent[]
   */
  public $intents;
  protected $intentsType = GoogleCloudContactcenterinsightsV1alpha1Intent::class;
  protected $intentsDataType = 'map';
  /**
   * @var GoogleCloudContactcenterinsightsV1alpha1IssueModelResult
   */
  public $issueModelResult;
  protected $issueModelResultType = GoogleCloudContactcenterinsightsV1alpha1IssueModelResult::class;
  protected $issueModelResultDataType = '';
  /**
   * @var GoogleCloudContactcenterinsightsV1alpha1PhraseMatchData[]
   */
  public $phraseMatchers;
  protected $phraseMatchersType = GoogleCloudContactcenterinsightsV1alpha1PhraseMatchData::class;
  protected $phraseMatchersDataType = 'map';
  /**
   * @var GoogleCloudContactcenterinsightsV1alpha1ConversationLevelSentiment[]
   */
  public $sentiments;
  protected $sentimentsType = GoogleCloudContactcenterinsightsV1alpha1ConversationLevelSentiment::class;
  protected $sentimentsDataType = 'array';

  /**
   * @param GoogleCloudContactcenterinsightsV1alpha1CallAnnotation[]
   */
  public function setAnnotations($annotations)
  {
    $this->annotations = $annotations;
  }
  /**
   * @return GoogleCloudContactcenterinsightsV1alpha1CallAnnotation[]
   */
  public function getAnnotations()
  {
    return $this->annotations;
  }
  /**
   * @param GoogleCloudContactcenterinsightsV1alpha1Entity[]
   */
  public function setEntities($entities)
  {
    $this->entities = $entities;
  }
  /**
   * @return GoogleCloudContactcenterinsightsV1alpha1Entity[]
   */
  public function getEntities()
  {
    return $this->entities;
  }
  /**
   * @param GoogleCloudContactcenterinsightsV1alpha1Intent[]
   */
  public function setIntents($intents)
  {
    $this->intents = $intents;
  }
  /**
   * @return GoogleCloudContactcenterinsightsV1alpha1Intent[]
   */
  public function getIntents()
  {
    return $this->intents;
  }
  /**
   * @param GoogleCloudContactcenterinsightsV1alpha1IssueModelResult
   */
  public function setIssueModelResult(GoogleCloudContactcenterinsightsV1alpha1IssueModelResult $issueModelResult)
  {
    $this->issueModelResult = $issueModelResult;
  }
  /**
   * @return GoogleCloudContactcenterinsightsV1alpha1IssueModelResult
   */
  public function getIssueModelResult()
  {
    return $this->issueModelResult;
  }
  /**
   * @param GoogleCloudContactcenterinsightsV1alpha1PhraseMatchData[]
   */
  public function setPhraseMatchers($phraseMatchers)
  {
    $this->phraseMatchers = $phraseMatchers;
  }
  /**
   * @return GoogleCloudContactcenterinsightsV1alpha1PhraseMatchData[]
   */
  public function getPhraseMatchers()
  {
    return $this->phraseMatchers;
  }
  /**
   * @param GoogleCloudContactcenterinsightsV1alpha1ConversationLevelSentiment[]
   */
  public function setSentiments($sentiments)
  {
    $this->sentiments = $sentiments;
  }
  /**
   * @return GoogleCloudContactcenterinsightsV1alpha1ConversationLevelSentiment[]
   */
  public function getSentiments()
  {
    return $this->sentiments;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudContactcenterinsightsV1alpha1AnalysisResultCallAnalysisMetadata::class, 'Google_Service_Contactcenterinsights_GoogleCloudContactcenterinsightsV1alpha1AnalysisResultCallAnalysisMetadata');
