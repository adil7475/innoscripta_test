import React from "react";
import {Card, CardBody, CardTitle, CardText} from 'reactstrap'
import NewsImage from '../../assets/images/news.jpg'
import {LatestNewsCardType} from "../../types/news-cards";

export const LatestCard = ({title, description, author, imageUrl, publishedAt}: LatestNewsCardType) => {
    const image = imageUrl ?? NewsImage
    return (
        <Card className="mb-3 col-md-12">
            <div className="row g-0">
                <div className="col-md-3">
                    <img src={image} className="img-fluid rounded-start" alt="News"/>
                </div>
                <div className="col-md-9">
                    <CardBody className="card-body">
                        <CardText className="card-text">
                            <span className="badge rounded-pill bg-secondary">{publishedAt}</span>
                        </CardText>
                        <CardTitle className="card-title">
                            {title}
                        </CardTitle>
                        <CardText className="card-text">
                            {description}
                        </CardText>
                        <div className="d-flex align-items-center justify-content-between flex-wrap">
                            <p className="card-text">
                                <small className="text-muted">Posted by: <strong>{author ?? 'unknown'}</strong></small>
                            </p>
                            <p className="text-end">
                                <a href="#" className="btn btn-primary cstm-btn">Read More</a>
                            </p>
                        </div>
                    </CardBody>
                </div>
            </div>
        </Card>
    )
}