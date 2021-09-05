import React from 'react';

class ListeAvisItem extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            avis: {}
        }
    }
    componentDidMount(){
        this.setState({avis: this.props.avis});
    }
    render(){
        // console.log('listAvisItem',this.state.avis);
        return(
            <div className="avis_item">
                <div className="avis_user">
                     <h3>{this.state.avis.user}</h3>
                </div>
               <div className="avis_detail">
                   <div className="avis_note">
                        <h3>{this.state.avis.note} / 20</h3>
                   </div>
                   <div className="avis_message">
                       <p>{this.state.avis.message}</p>
                   </div>
                   
               </div>
                
            </div>
        )
    }
}

export default ListeAvisItem;