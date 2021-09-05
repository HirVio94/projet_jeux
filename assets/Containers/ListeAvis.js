import React from 'react';
import ListeAvisItem from '../Components/ListeAvisItem';

class ListeAvis extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            listeAvis: []
        }
    }

    componentDidMount(){
        this.setState({listeAvis: this.props.listeAvis});
    }

    render(){
        console.log('listeAvis', this.state.listeAvis);
        return(
            <div className="avis_liste_item">
                
                <div>
                    {this.state.listeAvis.map(avis => {
                    return <ListeAvisItem avis={avis} />
                })}
                </div>
                
            </div>
        )
    }
}

export default ListeAvis;