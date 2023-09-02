import './MeasurementTable.styl';

import React, { Component } from 'react';
import { withTranslation } from '../../contextProviders';

import { Icon } from './../../elements/Icon';
import { MeasurementTableItem } from './MeasurementTableItem.js';
import { OverlayTrigger } from './../overlayTrigger';
import PropTypes from 'prop-types';
import { ScrollableArea } from './../../ScrollableArea/ScrollableArea.js';
import { TableList } from './../tableList';
import { Tooltip } from './../tooltip';

var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

class MeasurementTable extends Component {
  static propTypes = {
    measurementCollection: PropTypes.array.isRequired,
    timepoints: PropTypes.array.isRequired,
    overallWarnings: PropTypes.object.isRequired,
    readOnly: PropTypes.bool,
    onItemClick: PropTypes.func,
    onRelabelClick: PropTypes.func,
    onDeleteClick: PropTypes.func,
    onEditDescriptionClick: PropTypes.func,
    selectedMeasurementNumber: PropTypes.number,
    t: PropTypes.func,
    saveFunction: PropTypes.func,
    retrieveFunction: PropTypes.func,
    onSaveComplete: PropTypes.func,
  };

  static defaultProps = {
    overallWarnings: {
      warningList: [],
    },
    readOnly: false,
  };

  state = {
    selectedKey: null,
  };

  render() {
    const { overallWarnings, saveFunction, t } = this.props;
    const hasOverallWarnings = overallWarnings.warningList.length > 0;

    return (
      <div className="measurementTable">
        <div className="measurementTableHeader">
          {hasOverallWarnings && (
            <OverlayTrigger
              key={'overwall-warning'}
              placement="left"
              overlay={
                <Tooltip
                  placement="left"
                  className="in tooltip-warning"
                  id="tooltip-left"
                  style={{}}
                >
                  <div className="warningTitle">
                    {t('Criteria nonconformities')}
                  </div>
                  <div className="warningContent">
                    {this.getWarningContent()}
                  </div>
                </Tooltip>
              }
            >
              <span className="warning-status">
                <span className="warning-border">
                  <Icon name="exclamation-triangle" />
                </span>
              </span>
            </OverlayTrigger>
          )}
          {this.getTimepointsHeader()}
        </div>
        <ScrollableArea>
          <div id="measurementArea">{this.getMeasurementsGroups()}</div>
        </ScrollableArea>
        <div className="measurementTableFooter">
          {saveFunction && (
            <button
              id = "saveMeasurementsbtn"
              onClick={this.saveFunction}
              className="saveBtn"
            >
              <Icon name="save" width="14px" height="14px" />
              Save measurements
            </button>
          )}
        </div>
      </div>
    );
  }  
  
  //Function that first gets the performed annotations, then the cookie that stores the username of the currently logged user, then sends both the username and annotations to the server (addAnnotation) function in database.php. Finally, it posts the result to be saved to the database via an AJAX call
  saveFunction = () => {
    console.log("Saving annotation");
    var state = localStorage.getItem('toolState');

    //method to get a specific cookie
    function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }
    var username = getCookie("user_name");
    console.log(username);
 
    //jQuert that sends the username and annotation to the server
    jQuery.post('http://51.195.202.88/lyankova/dicom-image-viewer/db/database.php?function=addAnnotation', {myKey: state, myKey1: username}, function(addAnnotation) 
    { 
      console.log("Variables passed");
    }).fail(function() 
    { 
      console.log("Variables not passed"); 
    });

    //AJAX call to the addAnnotation function to the database.php file - saves the annotations to the database in a JSON format
    $.ajax({
      type: "POST",
      url: 'http://51.195.202.88/lyankova/dicom-image-viewer/db/database.php',
      data: 'function=addAnnotation',
      success: function(response){
        alert("Annotations saved!");
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); 
        alert("Error: " + errorThrown); 
      }       
    })
  };

  getMeasurementsGroups = () => {
    return this.props.measurementCollection.map((measureGroup, index) => {
      return (
        <TableList
          key={index}
          customHeader={this.getCustomHeader(measureGroup)}
        >
          {this.getMeasurements(measureGroup)}
        </TableList>
      );
    });
  };

  getMeasurements = measureGroup => {
    const selectedKey = this.props.selectedMeasurementNumber
      ? this.props.selectedMeasurementNumber
      : this.state.selectedKey;
    return measureGroup.measurements.map((measurement, index) => {
      const key = measurement.measurementNumber;
      const itemIndex = measurement.itemNumber || index + 1;
      const itemClass =
        selectedKey === key && !this.props.readOnly ? 'selected' : '';

      return (
        <MeasurementTableItem
          key={key}
          itemIndex={itemIndex}
          itemClass={itemClass}
          measurementData={measurement}
          onItemClick={this.onItemClick}
          onRelabel={this.props.onRelabelClick}
          onDelete={this.props.onDeleteClick}
          onEditDescription={this.props.onEditDescriptionClick}
        />
      );
    });
  };

  onItemClick = (event, measurementData) => {
    if (this.props.readOnly) return;

    this.setState({
      selectedKey: measurementData.measurementNumber,
    });

    if (this.props.onItemClick) {
      this.props.onItemClick(event, measurementData);
    }
  };

  getCustomHeader = measureGroup => {
    return (
      <React.Fragment>
        <div className="tableListHeaderTitle">
          {this.props.t(measureGroup.groupName)}
        </div>
        {measureGroup.maxMeasurements && (
          <div className="maxMeasurements">
            {this.props.t('MAX')} {measureGroup.maxMeasurements}
          </div>
        )}
        <div className="numberOfItems">{measureGroup.measurements.length}</div>
      </React.Fragment>
    );
  };

  getTimepointsHeader = () => {
    const { timepoints, t } = this.props;

    return timepoints.map((timepoint, index) => {
      return (
        <div key={index} className="measurementTableHeaderItem">
          <div className="timepointLabel">{t(timepoint.key)}</div>
          <div className="timepointDate">{timepoint.date}</div>
        </div>
      );
    });
  };

  getWarningContent = () => {
    const { warningList = '' } = this.props.overallWarnings;

    if (Array.isArray(warningList)) {
      const listedWarnings = warningList.map((warn, index) => {
        return <li key={index}>{warn}</li>;
      });

      return <ol>{listedWarnings}</ol>;
    } else {
      return <React.Fragment>{warningList}</React.Fragment>;
    }
  };
}

const connectedComponent = withTranslation(['MeasurementTable', 'Common'])(
  MeasurementTable
);
export { connectedComponent as MeasurementTable };
export default connectedComponent;
