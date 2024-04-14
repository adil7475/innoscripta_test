import React from "react";
import {Card, CardBody, CardText, CardTitle} from "reactstrap";
import { HeadlineNewsCardType } from "../../types/news-cards";
import NewsImage from '../../assets/images/news.jpg'
import ClampLines from "react-clamp-lines";

export const HeadlineCard = ({title, description, author, imageUrl}: HeadlineNewsCardType) => {
    const image = imageUrl ? imageUrl : NewsImage
    return (
        <div className="mb-3 col-md-12">
            <Card>
                <img src={image} className="card-img-top" alt="News"/>
                <CardBody>
                    <p className="card-text mb-1">
                        <small className="text-muted">Posted by: {author ?? 'Unknown'}</small>
                    </p>
                    <CardTitle>{title}</CardTitle>
                    <CardText>
                        {/*<ClampLines*/}
                        {/*    id='description'*/}
                        {/*    text={description ?? ''}*/}
                        {/*    lines={2}*/}
                        {/*    ellipsis="..."*/}
                        {/*    buttons={false}*/}
                        {/*/>*/}
                        {description}
                    </CardText>
                    <a href="#" className="btn btn-primary cstm-btn">Read More</a>
                </CardBody>
            </Card>
        </div>
    )
}